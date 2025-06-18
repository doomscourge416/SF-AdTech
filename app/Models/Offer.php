<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'target_url', 'payout', 'user_id'];

    public function affiliateLinks()
    {
        return $this->hasMany(\App\Models\AffiliateLink::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function clicks()
    {
        return $this->hasManyThrough(
            Click::class,
            AffiliateLink::class,
            'offer_id',       // foreign key на Offer в affiliate_links
            'affiliate_link_id', // foreign key на affiliate_link_id в clicks
            'id',              // local key в Offer
            'id'               // local key в affiliate_links
        );
    }

    public function getTotalClicksAttribute()
    {
        return $this->clicks()->count();
    }

    public function getTodayClicksAttribute()
    {
        return $this->clicks()
            ->whereDate('clicks.created_at', today())
            ->count();
    }

    public function getThisMonthClicksAttribute()
    {
        return $this->clicks()
            ->whereYear('clicks.created_at', now()->year)
            ->whereMonth('clicks.created_at', now()->month)
            ->count();
    }

    public function getThisYearClicksAttribute()
    {
        return $this->clicks()
            ->whereYear('clicks.created_at', now()->year)
            ->count();
    }

    public function getSystemEarningsAttribute()
    {
        return round($this->today_clicks * $this->payout * config('app.commission.system', 0.2), 2);
    }

    public function getWebmasterEarningsAttribute()
    {
        return round($this->today_clicks * $this->payout * config('app.commission.webmaster', 0.8), 2);
    }

}
