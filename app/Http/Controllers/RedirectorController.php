<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliateLink;
use App\Models\Click;
use Illuminate\Support\Facades\Redirect;

class RedirectorController extends Controller
{
	public function redirect(string $token)
	{
		// Ищем ссылку по токену
		$link = AffiliateLink::where('token', $token)->first();

		if (!$link) {
			abort(404, 'Ссылка не найдена');
		}

		// Логируем клик
		Click::create([
			'affiliate_link_id' => $link->id,
			'ip' => request()->ip(),
			'user_agent' => request()->userAgent(),
		]);

		// Редиректим на целевой URL
		return Redirect::away($link->offer->target_url);
	}
}
