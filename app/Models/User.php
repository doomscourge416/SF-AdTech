<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    ];

    const ROLE_ADVERTISER = 'advertiser';
    const ROLE_WEBMASTER = 'webmaster';
    const ROLE_ADMIN = 'admin';

    public function getRole()
    {
        return $this->attributes['role'] ?? self::ROLE_WEBMASTER;
    }

    public function isWebmaster()
    {
        return $this->getRole() === self::ROLE_WEBMASTER;
    }

    public function isAdvertiser()
    {
        return $this->getRole() === self::ROLE_ADVERTISER;
    }

    public function isAdministrator()
    {
        return $this->getRole() === self::ROLE_ADMIN;
    }

    // Связь: пользователь может иметь много офферов
    public function offers()
    {
        return $this->hasMany(\App\Models\Offer::class);
    }

    // Связь: пользователь может иметь много affiliate-ссылок
    public function affiliateLinks()
    {
        return $this->hasMany(\App\Models\AffiliateLink::class);
    }
}
