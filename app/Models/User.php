<?php

namespace App\Models;

use App\Enums\Role as RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasAgent()
    {
        return $this->hasOne(Agent::class)->with('kecamatan');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Properti favorit (pencari properti).
     */
    public function favorit()
    {
        return $this->belongsToMany(Property::class, 'favorites')->withTimestamps();
    }

    /** @var array<int, string>|null */
    private ?array $favoritIdsCache = null;

    /**
     * ID properti favorit, di-cache per request (dipakai kartu listing).
     *
     * @return array<int, string>
     */
    public function favoritIds(): array
    {
        return $this->favoritIdsCache ??= $this->favorit()->pluck('properties.id')->all();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Role user sebagai enum, atau null jika role tidak dikenal.
     */
    public function roleEnum(): ?RoleEnum
    {
        return RoleEnum::tryFrom(strtolower((string) $this->role?->name));
    }

    /**
     * @param  string|RoleEnum|array<int, string|RoleEnum>  $roles
     */
    public function hasRole($roles): bool
    {
        $current = $this->roleEnum();
        if ($current === null) {
            return false;
        }

        foreach ($roles instanceof RoleEnum ? [$roles] : (array) $roles as $role) {
            $role = $role instanceof RoleEnum ? $role : RoleEnum::tryFrom(strtolower($role));
            if ($role === $current) {
                return true;
            }
        }
        return false;
    }

    /**
     * URL halaman utama user setelah login sesuai role.
     */
    public function homeUrl(): string
    {
        return route($this->roleEnum()?->homeRoute() ?? 'front.home');
    }
}
