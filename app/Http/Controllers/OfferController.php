<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Click;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


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

        // Общее количество кликов по офферу через аффилиатные ссылки
        $totalClicks = Click::whereHas('affiliateLink', function ($query) use ($offer) {
            $query->where('offer_id', $offer->id);
        })->count();

        // Клики за сегодня
        $todayClicks = Click::whereDate('created_at', today())
            ->whereHas('affiliateLink', function ($query) use ($offer) {
                $query->where('offer_id', $offer->id);
            })
            ->count();

        return view('offers.show', compact('offer', 'totalClicks', 'todayClicks'));
    }

}
