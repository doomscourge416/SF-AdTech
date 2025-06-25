<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offer;
use App\Models\AffiliateLink;
use App\Models\Click;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Проверяем, залогинен ли пользователь
        if (!Auth::check()) {
            abort(403, 'Вы не авторизованы');
        }

        // И проверяем роль
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Только администратор может открыть эту страницу');
        }

        // Статистика
        $users = User::where('id', '!=', Auth::id())->get();
        $offers = Offer::withCount(['affiliateLinks', 'clicks'])->get();
        $totalClicks = Click::count();
        $totalLinks = AffiliateLink::count();

        return view('admin.dashboard', compact(
            'users',
            'offers',
            'totalLinks',
            'totalClicks'
        ));
    }

    public function approve(Request $request, $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->is_approved = true;
        $user->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Пользователь одобрен']);
        }

        return back()->with('status', 'Пользователь одобрен');
    }
}
