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
        return $this->belongsTo(Kategori::class,'kategori_id','id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_property', 'property_id', 'fasilitas_id');
    }

    public function gambars()
    {
        return $this->hasMany(Gambar::class)->orderByDesc('isDefault')->orderBy('id');
    }

    public function gambarUtama()
    {
        return $this->hasOne(Gambar::class)->ofMany(['isDefault' => 'max', 'id' => 'min']);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', PropertyStatus::Approved);
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
