<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function uploadedscreenshots(): HasMany
    {
        return $this->hasMany(Screenshot::class, 'uploaded_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps(); // Assuming you have this relation setup in your User model
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('role_name', $roles)->exists();
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }
}
