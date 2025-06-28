<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Click;
use App\Models\AffiliateLink;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Получаем всех пользователей, кроме себя
        $users = User::where('id', '!=', auth()->id())->get();

        // Статистика по дням
        $clicksByDay = Click::selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Доход системы по дням
        $revenueByDay = DB::table('clicks')
            ->join('affiliate_links', 'clicks.affiliate_link_id', '=', 'affiliate_links.id')
            ->join('offers', 'affiliate_links.offer_id', '=', 'offers.id')
            ->selectRaw('DATE(clicks.created_at) as date, SUM(offers.payout * 0.2) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('revenue', 'date');

        return view('admin.dashboard', compact('users', 'clicksByDay', 'revenueByDay'));
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
