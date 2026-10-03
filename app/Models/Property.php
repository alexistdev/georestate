<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /** Periode sewa => label, urutan tampil */
    public const PERIODE_HARGA = [
        'harga_harian' => 'Hari',
        'harga_bulanan' => 'Bulan',
        'harga_tahunan' => 'Tahun',
    ];

    /** Batas foto per listing */
    public const MAX_GAMBAR = 10;

    protected $fillable = [
        'agent_id', 'name', 'kecamatan_id', 'kategori_id', 'address', 'description',
        'beds', 'baths', 'lb', 'lt', 'harga_harian', 'harga_bulanan', 'harga_tahunan',
        'isPremium', 'isPremium_expired',
    ];
    protected $table = 'properties';

    protected $casts = [
        'isPremium' => 'bool',
        'status' => PropertyStatus::class,
        'approved_at' => 'datetime',
        'harga_harian' => 'integer',
        'harga_bulanan' => 'integer',
        'harga_tahunan' => 'integer',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            $property->slug ??= Str::slug(Str::limit($property->name, 80, '')).'-'.Str::lower(Str::random(6));
        });
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id','id')->select('id','kabupaten_id','name')->with('kabupaten');
    }

    public function kategori()
    {
        // withTrashed: listing lama tetap menampilkan kategori yang sudah dihapus admin.
        return $this->belongsTo(Kategori::class,'kategori_id','id')->withTrashed();
    }

    public function fasilitas()
    {
        // withTrashed: listing lama tetap menampilkan fasilitas yang sudah dihapus admin.
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_property', 'property_id', 'fasilitas_id')->withTrashed();
    }

    public function gambars()
    {
        return $this->hasMany(Gambar::class)->orderByDesc('isDefault')->orderBy('id');
    }

    public function gambarUtama()
    {
        return $this->hasOne(Gambar::class)->ofMany(['isDefault' => 'max', 'id' => 'min']);
    }

    /**
     * URL foto utama, atau gambar default jika belum ada foto.
     */
    public function gambarUtamaUrl(): string
    {
        return $this->gambarUtama?->url ?? Gambar::defaultUrl();
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', PropertyStatus::Approved);
    }

    /**
     * Listing yang boleh tampil di website: disetujui admin dan agennya tidak disuspend.
     */
    public function scopePublik(Builder $query): void
    {
        $query->approved()->whereHas('agent', fn (Builder $agent) => $agent->where('isSuspend', false));
    }

    /**
     * Filter & urutan pencarian halaman publik.
     * Rentang harga dan urutan harga memakai kolom periode yang dipilih (default bulanan).
     *
     * @param  array{q?: string, kategori?: int, provinsi?: int, kabupaten?: int, kecamatan?: int,
     *     periode?: string, harga_min?: int, harga_max?: int, kamar?: int, urut?: string}  $filter
     */
    public function scopeFilter(Builder $query, array $filter): void
    {
        $kolomHarga = self::kolomHarga($filter['periode'] ?? null);

        $query
            ->when($filter['q'] ?? null, function (Builder $q, string $kata) {
                $q->where(function (Builder $q) use ($kata) {
                    $q->where('name', 'like', "%{$kata}%")
                        ->orWhere('address', 'like', "%{$kata}%")
                        ->orWhere('description', 'like', "%{$kata}%");
                });
            })
            ->when($filter['kategori'] ?? null, fn (Builder $q, $id) => $q->where('kategori_id', $id))
            ->when($filter['kecamatan'] ?? null, fn (Builder $q, $id) => $q->where('kecamatan_id', $id))
            ->when(
                empty($filter['kecamatan']) ? ($filter['kabupaten'] ?? null) : null,
                fn (Builder $q, $id) => $q->whereIn('kecamatan_id', Kecamatan::select('id')->where('kabupaten_id', $id))
            )
            ->when(
                empty($filter['kecamatan']) && empty($filter['kabupaten']) ? ($filter['provinsi'] ?? null) : null,
                fn (Builder $q, $id) => $q->whereIn(
                    'kecamatan_id',
                    Kecamatan::select('id')->whereIn('kabupaten_id', Kabupaten::select('id')->where('provinsi_id', $id))
                )
            )
            ->when(isset($filter['periode']), fn (Builder $q) => $q->whereNotNull($kolomHarga))
            ->when($filter['harga_min'] ?? null, fn (Builder $q, $min) => $q->where($kolomHarga, '>=', $min))
            ->when($filter['harga_max'] ?? null, fn (Builder $q, $max) => $q->where($kolomHarga, '<=', $max))
            ->when($filter['kamar'] ?? null, fn (Builder $q, $kamar) => $q->where('beds', '>=', $kamar));

        match ($filter['urut'] ?? 'terbaru') {
            'termurah' => $query->orderByRaw("{$kolomHarga} is null")->orderBy($kolomHarga),
            'termahal' => $query->orderByRaw("{$kolomHarga} is null")->orderByDesc($kolomHarga),
            default => $query->latest('approved_at')->latest(),
        };
    }

    /**
     * Nama kolom harga untuk periode `harian|bulanan|tahunan` (default bulanan).
     */
    public static function kolomHarga(?string $periode): string
    {
        $kolom = 'harga_'.$periode;

        return array_key_exists($kolom, self::PERIODE_HARGA) ? $kolom : 'harga_bulanan';
    }

    /**
     * Harga yang ditonjolkan di kartu listing: periode yang sedang difilter jika ada,
     * selain itu bulanan, lalu periode pertama yang tersedia.
     *
     * @param  string|null  $periode  harian|bulanan|tahunan
     * @return array{0: string, 1: string}|null  [harga terformat, label periode]
     */
    public function hargaUtama(?string $periode = null): ?array
    {
        $harga = $this->daftarHarga();
        if ($harga === []) {
            return null;
        }

        $labelDipilih = $periode ? self::PERIODE_HARGA[self::kolomHarga($periode)] : 'Bulan';
        $label = array_key_exists($labelDipilih, $harga) ? $labelDipilih : array_key_first($harga);

        return [$harga[$label], $label];
    }

    public function punyaKoordinat(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /**
     * Harga yang terisi, mis. ['Bulan' => 'Rp 1.500.000'].
     *
     * @return array<string, string>
     */
    public function daftarHarga(): array
    {
        $hasil = [];
        foreach (self::PERIODE_HARGA as $kolom => $label) {
            if ($this->{$kolom} !== null) {
                $hasil[$label] = self::formatRupiah($this->{$kolom});
            }
        }
        return $hasil;
    }

    public static function formatRupiah(int $nilai): string
    {
        return 'Rp '.number_format($nilai, 0, ',', '.');
    }

    /**
     * Lokasi lengkap, mis. "KECAMATAN X, KABUPATEN Y, PROVINSI Z".
     */
    public function lokasi(): string
    {
        $kecamatan = $this->kecamatan;
        return collect([
            $kecamatan?->name,
            $kecamatan?->kabupaten?->name,
            $kecamatan?->kabupaten?->provinsi?->name,
        ])->filter()->implode(', ');
    }
}
