@extends('layouts.app')
@section('title', 'Все офферы')
@section('content')
    <h1>Доступные офферы</h1>

    @if(count($offers) > 0)
        <ul>
            @foreach($offers as $offer)
                <li>
                    {{ $offer->title }} — {{ $offer->payout }} руб.
                    <form method="POST" action="/webmaster/subscribe/{{ $offer->id }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Подписаться</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>Нет доступных офферов</p>
    @endif

    <a href="/webmaster/links" class="btn btn-primary mt-3">Мои ссылки</a>
@endsection
