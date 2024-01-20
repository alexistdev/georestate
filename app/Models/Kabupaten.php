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
}
