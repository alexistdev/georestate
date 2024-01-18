<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $table = 'kategoris';

    protected function id():Attribute
    {
        return Attribute::make(
            get: fn(string $value) => base64_encode($value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value),
        );
    }
}
