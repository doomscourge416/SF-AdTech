@extends('layouts.app')

@section('title', 'SF-AdTech — Главная')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Добро пожаловать в SF-AdTech</h1>
        <p class="lead text-center">Система управления трафиком и монетизации</p>

        @if (Route::has('login'))
            <div class="mt-5">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Перейти в личный кабинет</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">Зарегистрироваться</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
@endsection
