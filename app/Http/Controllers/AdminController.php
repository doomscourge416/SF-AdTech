<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Click;
use App\Models\AffiliateLink;
use App\Models\Offer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        // 1. График доходов (аналогично вебмастеру)
        $revenueData = DB::table('clicks')
            ->join('affiliate_links', 'clicks.affiliate_link_id', '=', 'affiliate_links.id')
            ->join('offers', 'affiliate_links.offer_id', '=', 'offers.id')
            ->selectRaw('strftime("%Y-%m", clicks.created_at) as month, SUM(offers.payout * 0.2) as revenue')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->revenue];
            });

        // 2. График кликов (простая группировка по дням)
        $clicksData = Click::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->count];
            });

        // 3. Источники трафика (аналогично вебмастеру)
        $sourcesData = Click::select('source')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('source')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->source => $item->count];
            });

        return view('admin.dashboard', [
            'users' => $users,
            'stats' => [
                'revenueByMonth' => $revenueData,
                'clicksLast30Days' => $clicksData,
                'trafficSources' => $sourcesData
            ]
        ]);
    }

    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('status', 'Пользователь одобрен');
    }

    public function block(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'blocked' ? 'active' : 'blocked';
        $user->save();

        return back()->with('status', 'Статус пользователя изменён');
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('status', 'Пользователь удалён');
    }
}
