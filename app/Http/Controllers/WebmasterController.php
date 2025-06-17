<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebmasterController extends Controller
{
    public function affiliateLinks()
{
    $links = \App\Models\AffiliateLink::with(['offer'])->get();
    return view('webmaster.links', compact('links'));
}
}
