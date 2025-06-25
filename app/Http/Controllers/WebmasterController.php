<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\AffiliateLink;
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
        $links = AffiliateLink::where('user_id', auth()->id())->with('offer')->get();
        return view('webmaster.links', compact('links'));
    }

    public function subscribe(Request $request, $offerId)
    {
        $offer = Offer::findOrFail($offerId);

        // Проверяем, есть ли уже у пользователя эта подписка
        $existingLink = AffiliateLink::where('user_id', auth()->id())
            ->where('offer_id', $offer->id)
            ->first();

        if (!$existingLink) {
            $token = Str::random(10);

            AffiliateLink::create([
                'user_id' => auth()->id(),
                'offer_id' => $offer->id,
                'token' => $token,
            ]);
        }

        return redirect('/webmaster/links');
    }

}
