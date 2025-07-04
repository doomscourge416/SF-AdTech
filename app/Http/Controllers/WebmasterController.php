<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\AffiliateLink;
use App\Models\Click;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebmasterController extends Controller
{
    public function index()
    {
        // Получаем все офферы, доступные для подписки
        // $offers = Offer::all();
        $offers = Offer::whereDoesntHave('affiliateLinks', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
        return view('webmaster.index', compact('offers'));
    }

    public function affiliateLinks()
    {
        // Все аффилиатные ссылки текущего пользователя
        $links = auth()->user()->affiliateLinks()->with('offer')->get();

        // Получаем клики по этим ссылкам
        $clicks = Click::whereIn('affiliate_link_id', $links->pluck('id'))
            ->selectRaw('affiliate_link_id, count(*) as total')
            ->groupBy('affiliate_link_id')
            ->pluck('total', 'affiliate_link_id');

        // Формируем данные для графика
        $chartData = [];

        foreach ($links as $link) {
            $offerTitle = $link->offer->title;
            $clickCount = $clicks[$link->id] ?? 0;
            $color = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); // генерация цвета

            $chartData[] = [
                'label' => $offerTitle,
                'clicks' => $clickCount,
                'color' => $color,
                'url' => '/go/' . $link->token
            ];
        }

        return view('webmaster.links', compact('links', 'chartData'));
    }

    public function subscribe(Request $request, $offerId)
    {
        $user = auth()->user();
        $offer = Offer::findOrFail($offerId);

        // Проверяем существующую подписку
        if ($user->subscriptions()->where('offer_id', $offer->id)->exists()) {
            return back()->with('error', 'Вы уже подписаны на этот оффер');
        }

        // Создаём подписку
        $subscription = $user->subscriptions()->create([
            'offer_id' => $offer->id,
            'token' => Str::random(32)
        ]);

        return redirect()->route('webmaster.links')
            ->with('success', 'Подписка оформлена! Ваша ссылка: '.url('/go/'.$subscription->token));
    }

}
