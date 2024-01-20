<?php

namespace App\Models;

use App\Casts\Base64;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    protected $fillable = ['kabupaten_id','name'];
    protected $table = 'kecamatans';

//    protected $casts = [
//        'id' => Base64::class
//    ];


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtoupper($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class)->select('id','provinsi_id','name')->with('provinsi');
    }


}
