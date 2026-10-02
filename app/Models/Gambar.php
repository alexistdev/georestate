<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gambar extends Model
{
    use SoftDeletes;

    /** Disk penyimpanan foto properti (storage/app/public, butuh `php artisan storage:link`) */
    public const DISK = 'public';

    /** Gambar pengganti jika listing belum punya foto atau file fotonya tidak ditemukan */
    public const DEFAULT = 'images/properties/default.jpg';

    protected $fillable = ['name','property_id','isDefault'];

    protected $casts = [
        'isDefault' => 'bool',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public static function defaultUrl(): string
    {
        return asset(self::DEFAULT);
    }

    /**
     * URL publik foto. Kolom `name` berisi path relatif di disk public.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk(self::DISK)->url($this->name),
        );
    }
}
