<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
