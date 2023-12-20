<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Provinsi extends Model
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */


    protected $fillable = ['code', 'name'];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value),
        );
    }
}
