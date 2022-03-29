<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    /**
     * GeoRestate v.2.0
     * Date: 29-03-2022
     * Author:AlexisDev
     * Email: alexistdev@gmail.com
     * Phone: 0823-7140-8678
     */

    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name',
    ];
}
