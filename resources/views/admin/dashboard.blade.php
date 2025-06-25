@extends('layouts.app')

@section('title', 'Панель администратора')
@section('content')
    <h1>Добро пожаловать, администратор</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Пользователи</h2>
            <table class="table table-bordered">
                <tr><th>ID</th><th>Имя</th><th>Email</th><th>Роль</th></tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if (!$user->is_approved)
                                <button class="btn btn-success btn-sm approve-btn" data-user-id="{{ $user->id }}">Одобрить</button>
                            @else
                                <span class="text-muted">Одобрен</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="col-md-6">
            <h2>Офферы</h2>
            <table class="table table-bordered">
                <tr><th>ID</th><th>Название</th><th>Клики</th><th>Подписки</th></tr>
                @foreach($offers as $offer)
                    <tr>
                        <td>{{ $offer->id }}</td>
                        <td>{{ $offer->title }}</td>
                        <td>{{ $offer->clicks_count }}</td>
                        <td>{{ $offer->affiliate_links_count }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="mt-4">
        <h2>Статистика</h2>
        <p>Всего аффилиатных ссылок: {{ $totalLinks }}</p>
        <p>Всего кликов: {{ $totalClicks }}</p>
    </div>

    <a href="/logout" class="btn btn-danger">Выйти из админки</a>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.approve-btn');

    buttons.forEach(button => {
        button.addEventListener('click', async () => {
            const userId = button.getAttribute('data-user-id');

            try {
                const res = await axios.post(`/admin/approve/${userId}`);
                if (res.data.success) {
                    // Обновляем интерфейс без перезагрузки
                    button.innerText = 'Одобрен';
                    button.disabled = true;
                }
            } catch (err) {
                alert('Ошибка при одобрении');
                console.error(err);
            }
        });
    });
});
</script>
@endsection
