@extends('layouts.app')

@section('title', 'Вход')
@section('content')
    <h1>Войти в систему</h1>

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <button type="submit">Войти</button>
    </form>
@endsection
