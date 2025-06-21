<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\AffiliateLink;

class WebmasterController extends Controller
{
    public function index()
    {
        // Получаем все офферы, доступные для подписки
        $offers = Offer::all();
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

        $link = AffiliateLink::firstOrCreate([
            'user_id' => auth()->id(),
            'offer_id' => $offerId,
            'token' => \Illuminate\Support\Str::random(10),
        ]);

        return redirect('/webmaster/links');
    }
}
