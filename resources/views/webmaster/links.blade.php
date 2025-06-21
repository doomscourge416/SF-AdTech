@extends('layouts.app')
@section('title', 'Мои ссылки')
@section('content')
    <h1>Мои аффилиатные ссылки</h1>

    @if(count($links) > 0)
        <ul>
            @foreach($links as $link)
                <li>
                    
                    {{ $link->offer->title }}
                    <a href="/go/{{ $link->token }}" target="_blank" class="btn btn-sm btn-success">
                        /go/{{ $link->token }}
                    </a>

                </li>
            @endforeach
        </ul>
    @else
        <p>Вы ещё ни на какие офферы не подписаны</p>
    @endif

    <a href="/webmaster" class="btn btn-secondary">Все офферы</a>
@endsection
