<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','kecamatan_id','address','description','beds','baths','lb','lt','price','isPremium','isPremium_expired'];
    protected $table = 'properties';
}
