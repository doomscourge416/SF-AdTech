@extends('layouts.app')

@section('title', 'Регистрация')
@section('content')
    <h1>Регистрация</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <input type="text" name="name" placeholder="Имя" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="password" name="password_confirmation" placeholder="Подтверждение пароля" required><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
@endsection
