<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kabupaten extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['provinsi_id', 'name'];

    protected $table = 'kabupatens';

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Kabupaten $parent) {

            foreach ($parent->kecamatan as $child) {
                $child->delete();
            }

        });
    }

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

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class)->select('id', 'name');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
}
