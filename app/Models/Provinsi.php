<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    use SoftDeletes;


    protected $fillable = ['name'];

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Provinsi $parent) {

            foreach ($parent->kabupaten as $child) $child->delete();

        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class);
    }
}
