<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fasilitas';
    protected $fillable = ['name'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'fasilitas_property', 'fasilitas_id', 'property_id');
    }
}
