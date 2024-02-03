<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','kecamatan_id','agent_id','address','description','beds','baths','lb','lt','price','isPremium','isPremium_expired','isStatus'];
    protected $table = 'properties';

    protected $casts = [
      'isPremium' => 'bool'
    ];

   public function kecamatan(){
       return $this->belongsTo(Kecamatan::class,'kecamatan_id','id')->select('id','kabupaten_id','name')->with('kabupaten');
   }

   public function kategori(){
       return $this->belongsTo(Kategori::class,'kategori_id','id');
   }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) =>  number_format($value,0,',','.')
        );
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }


}
