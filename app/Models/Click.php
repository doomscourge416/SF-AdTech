<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_link_id',
        'ip',
        'user_agent',
        'source',
        'created_at' 
    ];

    // Связь с affiliate_link
    public function affiliateLink()
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    // Связь с offer через affiliate_link
    public function offer()
    {
        return $this->belongsToThrough(Offer::class, AffiliateLink::class);
    }

}
