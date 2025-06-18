@extends('layouts.app')

@section('title', 'Статистика оффера')
@section('content')
    <h1>{{ $offer->title }}</h1>
    <p><strong>Целевой URL:</strong> {{ $offer->target_url }}</p>
    <p><strong>Выплата за клик:</strong> {{ $offer->payout }} руб.</p>

    <hr>

    <h2>Статистика</h2>
    <ul>
        <li>Клики за сегодня: {{ $todayClicks }}</li>
        <li>Всего кликов: {{ $totalClicks }}</li>
        <li>Доход за сегодня: {{ $todayClicks * $offer->payout }}</li>
        <li>Общий доход: {{ $totalClicks * $offer->payout }}</li>
    </ul>

    <a href="/offers" class="btn btn-secondary">Назад к списку</a>
@endsection
