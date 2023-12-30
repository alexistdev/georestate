<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasUuids,SoftDeletes;

    protected $fillable = ['user_id','member_identifier','phone','kelurahan_id','alamat','about','isSuspend','level','kecamatan_id'];

    public function hasUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id','id')->with('kabupaten');
    }
}
