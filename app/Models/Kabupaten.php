<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
   protected $fillable = ['provinsi_id','name'];
   protected $table ='kabupatens';

   protected function hasProvinsi(){
       return $this->belongsTo(Provinsi::class);
   }
}
