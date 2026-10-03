<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use App\Support\Telepon;
use Illuminate\Database\Eloquent\Model;

/**
 * Pertanyaan calon penyewa ke agen dari halaman detail properti.
 */
class Inquiry extends Model
{
    protected $fillable = ['property_id', 'agent_id', 'user_id', 'name', 'email', 'phone', 'message'];

    protected $casts = [
        'status' => InquiryStatus::class,
        'read_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'baru',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class)->withTrashed();
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function whatsappUrl(?string $pesan = null): ?string
    {
        return Telepon::whatsappUrl($this->phone, $pesan);
    }
}
