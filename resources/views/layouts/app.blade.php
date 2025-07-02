<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') — SF-AdTech</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">SF-AdTech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth

                    <li class="nav-item">
                            <a class="nav-link" href="/webmaster/links">Доступные офферы</a>
                    </li>

                    <li class="nav-item">
                            <a class="nav-link" href="/offers">Все Офферы</a>
                    </li>

                    <li class="nav-item">
                            <a class="nav-link" href="/affiliate-links">Аффилитивные ссылки</a>
                    </li>

                    @if (auth()->user()->isAdvertiser())
                        <li class="nav-item">
                            <a class="nav-link" href="/offers">Список Своих Офферов</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/offers/create">Создать оффер</a>
                        </li>
                    @endif

                    @if (auth()->user()->isWebmaster())
                        <li class="nav-item">
                            <a class="nav-link" href="/webmaster">Веб-мастер</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webmaster/links">Доступные офферы</a>
                        </li>
                    @endif

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Админка</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Регистрация</a>
                    </li>
                @else
                    <li class="nav-item">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Выйти из аккаунта</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Content wrapper -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">@yield('title')</h2>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @yield('content')

</div>

<!-- Footer -->
<footer class="footer mt-5 py-3 bg-white text-center border-top">
    <div class="container">
        <span class="text-muted">© 2025 SF-AdTech — MVP v1.4</span>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
<!-- @yield('scripts') -->
</body>
</html>
