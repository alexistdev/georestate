<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasUuids,SoftDeletes;
//    protected $searc = ['member_identifier','phone','level'];
    protected $fillable = ['user_id','member_identifier','phone','kelurahan_id','alamat','about','isSuspend','level'];

    public function hasUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
