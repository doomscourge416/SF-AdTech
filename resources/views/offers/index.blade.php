@extends('layouts.app')

@section('title', 'Офферы')
@section('content')
    <h1>Список офферов</h1>
    <ul>
        @foreach($offers as $offer)
            <li>
                <a href="/offers/{{ $offer->id }}">{{ $offer->title }}</a>
                — {{ $offer->payout }} руб.
            </li>
        @endforeach
    </ul>
@endsection
