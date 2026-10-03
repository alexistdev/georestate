<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['kabupaten_id', 'name'];

    protected $table = 'kecamatans';

    /**
     * Nama disimpan huruf kecil (seperti data seeder) dan selalu ditampilkan huruf kapital.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value === null ? null : mb_strtoupper($value),
            set: fn (?string $value) => $value === null ? null : mb_strtolower(trim($value)),
        );
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class)->select('id', 'provinsi_id', 'name')->with('provinsi');
    }
}
