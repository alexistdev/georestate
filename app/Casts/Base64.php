<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Base64 implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return base64_encode($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }

}
