@extends('layouts.app')

@section('title', 'Мои ссылки')
@section('content')
    <h1>Аффилиатные ссылки</h1>
    <ul>
        @foreach($links as $link)
            <li>
                {{ $link->offer->title ?? 'Нет оффера' }} —
                <code>/go/{{ $link->token }}</code>
            </li>
        @endforeach
    </ul>
@endsection