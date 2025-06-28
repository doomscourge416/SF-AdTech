@extends('layouts.app')
@section('title', 'Панель администратора')
@section('content')

<h1>Добро пожаловать, администратор</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<hr>

<h2>Пользователи</h2>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Статус</th>
        <th>Одобрен</th>
        <th>Действия</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ ucfirst($user->status) }}</td>
            <td>{{ $user->is_approved ? '✅' : '❌' }}</td>
            <td>
                @if(!$user->is_approved)
                    <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                    </form>
                @endif

                <form action="{{ route('admin.block', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning">
                        {{ $user->status === 'blocked' ? 'Разблокировать' : 'Заблокировать' }}
                    </button>
                </form>

                <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<hr>

<h2>Статистика</h2>

<div class="row">
    <div class="col-md-6">
        <canvas id="clicksChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
<script>
    const ctxClicks = document.getElementById('clicksChart').getContext('2d');
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

    const labels = @json(array_keys($clicksByDay->toArray()));
    const clicksData = @json(array_values($clicksByDay->toArray()));
    const revenueData = @json(array_values($revenueByDay->toArray()));

    new Chart(ctxClicks, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Клики по дням',
                data: clicksData,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Доход системы',
                data: revenueData,
                backgroundColor: '#1cc88a'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
