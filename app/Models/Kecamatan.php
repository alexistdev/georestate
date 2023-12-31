<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    protected $fillable = ['kabupaten_id','name'];
    protected $table = 'kecamatans';

    protected function id():Attribute
    {
        return Attribute::make(
            get: fn(string $value) => base64_encode($value),
        );
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class)->with('provinsi');
    }
}
