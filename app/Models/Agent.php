<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Agent extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['user_id','member_identifier','phone','kelurahan_id','alamat','about','isSuspend','level','kecamatan_id'];

    /** Foto pengganti jika agen belum punya foto atau file fotonya tidak ditemukan */
    public const FOTO_DEFAULT = 'images/agents/man.png';

    protected $casts = [
        'isSuspend' => 'bool',
        'suspended_at' => 'datetime',
    ];

    public function hasUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Pesan untuk agen yang disuspend (ditampilkan saat login / dikeluarkan dari sesi).
     */
    public function pesanSuspend(): string
    {
        return 'Akun agen Anda disuspend'
            .($this->alasan_suspend ? ': '.rtrim($this->alasan_suspend, '. ').'.' : '.')
            .' Silakan hubungi administrator.';
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id','id')->with('kabupaten');
    }

    /**
     * Agen yang boleh tampil di website (tidak disuspend).
     */
    public function scopeAktif(Builder $query): void
    {
        $query->where('isSuspend', false);
    }

    public function fotoUrl(): string
    {
        return $this->gambar
            ? Storage::disk(Gambar::DISK)->url($this->gambar)
            : asset(self::FOTO_DEFAULT);
    }

    /**
     * Nomor telepon format internasional tanpa "+", mis. 081234 → 6281234. Null jika kosong.
     */
    public function nomorInternasional(): ?string
    {
        $nomor = preg_replace('/\D/', '', (string) $this->phone);
        if ($nomor === '') {
            return null;
        }
        if (str_starts_with($nomor, '0')) {
            return '62'.substr($nomor, 1);
        }
        if (str_starts_with($nomor, '8')) {
            return '62'.$nomor;
        }
        return $nomor;
    }

    public function whatsappUrl(?string $pesan = null): ?string
    {
        $nomor = $this->nomorInternasional();
        if ($nomor === null) {
            return null;
        }
        return 'https://wa.me/'.$nomor.($pesan ? '?text='.rawurlencode($pesan) : '');
    }

    public function teleponUrl(): ?string
    {
        $nomor = $this->nomorInternasional();

        return $nomor ? 'tel:+'.$nomor : null;
    }
}
