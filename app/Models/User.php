<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use App\Traits\HasUuidV7;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasUuidV7;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Traits\Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin(): bool
    {
        // Developer tiene todos los permisos de admin
        return $this->role === 'admin' || $this->role === 'developer';
    }

    public function isManager(): bool
    {
        return $this->role === 'gerente';
    }

    public function isCashier(): bool
    {
        return $this->role === 'cajero';
    }

    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
