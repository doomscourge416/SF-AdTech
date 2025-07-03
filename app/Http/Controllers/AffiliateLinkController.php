<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;

class AffiliateLinkController extends Controller
{
    public function index()
    {
        $links = auth()->user()
            ->affiliateLinks()
            ->with(['offer', 'clicks'])
            ->paginate(10);

        return view('webmaster.links', [
            'links' => $links,
            'totalEarnings' => $links->sum(fn($link) => $link->clicks->count() * $link->offer->payout * 0.8)
        ]);
    }
}
