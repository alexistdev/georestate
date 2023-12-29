<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    protected $fillable = ['kabupaten_id','name'];
    protected $table = 'kecamatans';

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
