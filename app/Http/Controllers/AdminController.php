<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offer;
use App\Models\AffiliateLink;
use App\Models\Click;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Только для админа
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Доступ запрещён');
        }

        // Статистика
        $users = User::where('role', '!=', 'admin')->get();
        $offers = Offer::withCount('affiliateLinks')->get();

        $totalLinks = AffiliateLink::count();
        $totalClicks = Click::count();

        return view('admin.dashboard', compact(
            'users',
            'offers',
            'totalLinks',
            'totalClicks'
        ));
    }
}
