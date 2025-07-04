<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory;

    /**
     * Поля, разрешенные для массового заполнения
     */
    protected $fillable = [
        'user_id',
        'offer_id',
        'token',
        'is_active'
    ];

    protected $dates = ['start_date', 'end_date'];

    /**
     *
     */
    // protected $attributes = [
    //     'is_active' => true
    // ];

    /**
     * Связь с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с оффером
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Генерация токена при создании подписки
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            $subscription->token = Str::random(32);
        });
    }

    /**
     * Проверка активной подписки
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Получение полной реферальной ссылки
     */
    public function getReferralLinkAttribute()
    {
        return url('/go/' . $this->token);
    }
}
