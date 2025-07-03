<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('dashboard.index', [
            'user' => $user,
            'role' => $user->getRole(),
            'stats' => $this->getUserStats($user)
        ]);
    }

    protected function getUserStats($user)
    {
        if ($user->isWebmaster()) {
            $links = $user->affiliateLinks()->with(['offer', 'clicks'])->get();

            return [
                'links_count' => $links->count(),
                'total_clicks' => $links->sum(fn($link) => $link->clicks->count()),
                'total_earnings' => $links->sum(function($link) {
                    return $link->clicks->count() * $link->offer->payout * 0.8;
                })
            ];
        }

        if ($user->isAdvertiser()) {
            return [
                'offers_count' => $user->offers()->count(),
                'active_offers' => $user->offers()->where('is_active', true)->count()
            ];
        }

        return [];
    }
}
