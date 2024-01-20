<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{

    protected $fillable = ['name','kecamatan_id','address','description','beds','baths','lb','lt','price','isPremium','isPremium_expired'];
    protected $table = 'properties';

    protected function kecamatanId():Attribute
    {
        return Attribute::make(
            get: fn(string $value) => base64_encode($value),
        );
    }
   public function kecamatan(){
       return $this->belongsTo(Kecamatan::class,'kecamatan_id')->select('id','name');
   }
}
