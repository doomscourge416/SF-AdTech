@extends('layouts.app')

@section('title', 'Доступные офферы')

@section('content')
<div class="container">
    <h1 class="mb-4">Доступные офферы</h1>

    @if($offers->isEmpty())
        <div class="alert alert-info">Нет доступных офферов для подключения</div>
    @else
        <div class="row">
            @foreach($offers as $offer)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $offer->title }}</h5>
                        <p class="card-text flex-grow-1">
                            <strong>Цена за клик:</strong> {{ $offer->payout }} руб.<br>
                            <strong>Описание:</strong> {{ $offer->description }}
                        </p>
                        <form action="{{ route('webmaster.subscribe', $offer->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle"></i> Подключиться
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $offers->links() }}
        </div>
    @endif
</div>
@endsection
