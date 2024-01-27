<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kabupaten extends Model
{
    use SoftDeletes;

    protected $fillable = ['provinsi_id','name'];
    protected $table = 'kabupatens';

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Kabupaten $parent) {

            foreach ($parent->kecamatan as $child) $child->delete();

        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class)->select('id','name');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
}
