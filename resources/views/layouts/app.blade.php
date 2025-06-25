<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<header>
    @if(auth()->check())
        @php($user = auth()->user())
        <h2>Привет, {{ $user->name }}</h2>

        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Выход</button>
        </form>
    @endif
</header>
<body>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
