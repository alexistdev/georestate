<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasUuids,SoftDeletes;
    protected $searchableAttributes = ['member_identifier','phone','level'];

    public function hasUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
