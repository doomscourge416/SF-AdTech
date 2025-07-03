@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Личный кабинет</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="display-4">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h4>{{ $user->name }}</h4>
                            <span class="badge bg-primary">{{ ucfirst($role) }}</span>
                        </div>
                        <div class="col-md-8">
                            @if($user->isWebmaster())
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Ссылок</h5>
                                                <p class="display-6">{{ $stats['links_count'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Переходов</h5>
                                                <p class="display-6">{{ $stats['total_clicks'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Общий заработок</h5>
                                                <p class="display-6">{{ $stats['total_earnings'] }} руб.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($user->isAdvertiser())
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Всего офферов</h5>
                                                <p class="display-6">{{ $stats['offers_count'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Активных</h5>
                                                <p class="display-6">{{ $stats['active_offers'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @if($user->isWebmaster())
                            <a href="{{ route('webmaster.links') }}" class="btn btn-primary btn-lg">
                                Мои партнерские ссылки
                            </a>
                        @endif

                        @if($user->isAdvertiser())
                            <a href="{{ route('offers.my') }}" class="btn btn-primary btn-lg">
                                Мои офферы
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
