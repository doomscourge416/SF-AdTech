<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
{
    $offers = \App\Models\Offer::with('user')->get();
    return view('offers.index', compact('offers'));
}
}
