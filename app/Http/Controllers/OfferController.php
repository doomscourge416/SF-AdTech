<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Click;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;


class OfferController extends Controller
{

    public function create()
    {
        return view('offers.create');
    }

    public function index()
    {
        $offers = \App\Models\Offer::with('user')->get();
        return view('offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'target_url' => 'required|url',
            'payout' => 'required|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Offer::create([
            'title' => $request->input('title'),
            'target_url' => $request->input('target_url'),
            'payout' => $request->input('payout'),
            'user_id' => auth()->id(),
        ]);

        return redirect('/offers')->with('status', 'Оффер успешно создан!');
    }

    public function show(Request $request, $id)
    {
        $offer = Offer::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $date = $request->input('date') ? new \Carbon\Carbon($request->input('date')) : now();

        $totalClicks = $offer->total_clicks;
        $todayClicks = $offer->today_clicks;
        $thisMonthClicks = $offer->this_month_clicks;
        $thisYearClicks = $offer->this_year_clicks;

        return view('offers.show', [
            'offer' => $offer,
            'totalClicks' => $offer->total_clicks,
            'todayClicks' => $offer->today_clicks,
            'thisMonthClicks' => $offer->this_month_clicks,
            'thisYearClicks' => $offer->this_year_clicks,
            'systemEarnings' => $offer->system_earnings,
            'webmasterEarnings' => $offer->webmaster_earnings,
        ]);

    }

    public function availableOffers()
    {
        $subscribedIds = auth()->user()->subscriptions()->pluck('offer_id');

        $offers = Offer::where('is_active', true)
            ->whereNotIn('id', $subscribedIds)
            ->paginate(10);

        return view('webmaster.available-offers', compact('offers'));
    }


    public function toggle(Offer $offer)
    {
        $offer->update(['is_active' => !$offer->is_active]);

        return back()->with('success', 'Статус оффера обновлен');
    }

}
