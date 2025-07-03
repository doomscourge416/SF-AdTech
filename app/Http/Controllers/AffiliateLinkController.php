<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\Offer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AffiliateLinkController extends Controller
{

    public function index()
    {
        // Сначала получаем данные
        $links = auth()->user()
            ->affiliateLinks()
            ->with(['offer', 'clicks'])
            ->paginate(10);

        // Затем генерируем данные для графика
        $chartData = $this->generateChartData($links);

        return view('webmaster.links', [
            'links' => $links,
            'chartData' => $chartData,
            'totalEarnings' => $links->sum(fn($link) => $link->clicks->count() * $link->offer->payout * 0.8)
        ]);
    }

    protected function generateChartData($links)
    {
        return $links->map(function($link) {
            return [
                'label' => $link->offer->title,
                'value' => $link->clicks->count(),
                'color' => '#' . substr(md5($link->offer->title), 0, 6)
            ];
        });
    }

}
