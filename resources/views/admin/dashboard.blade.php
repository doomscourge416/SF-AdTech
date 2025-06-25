@extends('layouts.app')

@section('title', 'Панель администратора')
@section('content')
    <h1>Панель администратора</h1>

    <div class="row">
        <!-- Неодобренные пользователи -->
        <div class="col-md-6">
            <h2>На модерации (ожидает одобрения)</h2>
            @if ($users->where('is_approved', false)->isNotEmpty())
                <table class="table table-bordered">
                    <tr><th>ID</th><th>Имя</th><th>Email</th><th>Роль</th><th>Действие</th></tr>
                    @foreach ($users->where('is_approved', false) as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <form method="POST" action="/admin/approve/{{ $user->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Одобрить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>Нет пользователей на модерации</p>
            @endif
        </div>

        <!-- Активные пользователи -->
        <div class="col-md-6">
            <h2>Активные пользователи</h2>
            @if ($users->where('is_approved', true)->isNotEmpty())
                <table class="table table-bordered">
                    <tr><th>ID</th><th>Имя</th><th>Email</th><th>Роль</th></tr>
                    @foreach ($users->where('is_approved', true) as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>Нет активных пользователей</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <h3>Статистика системы</h3>
        <ul>
            <li>Всего ссылок: {{ $totalLinks }}</li>
            <li>Всего кликов: {{ $totalClicks }}</li>
            <li>Неактивных пользователей: {{ $users->where('is_approved', false)->count() }}</li>
            <li>Активных пользователей: {{ $users->where('is_approved', true)->count() }}</li>
        </ul>
    </div>

    <a href="/logout" class="btn btn-danger mt-3">Выйти из админки</a>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.approve-btn');

            buttons.forEach(button => {
                button.addEventListener('click', async () => {
                    const userId = button.getAttribute('data-user-id');
                    const row = button.closest('tr');

                    try {
                        const response = await fetch(`/admin/approve/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Удаляем строку пользователя после одобрения
                            row.remove();
                        }

                    } catch (err) {
                        console.error('Ошибка:', err);
                        alert('Не удалось одобрить пользователя');
                    }
                });
            });
        });
    </script>
@endsection
