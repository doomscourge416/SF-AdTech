<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'offer_id', 'token'];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function clicks()
    {
        return $this->hasMany(\App\Models\Click::class);
    }
    
}
