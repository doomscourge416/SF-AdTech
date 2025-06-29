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

<div class="row mt-4">
    <!-- График доходов -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Доходы системы (последние 6 месяцев)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="250" ></canvas>
            </div>
        </div>
    </div>

    <!-- График кликов -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Клики (последние 30 дней)</h5>
            </div>
            <div class="card-body">
                <canvas id="clicksChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Источники трафика -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Источники трафика</h5>
            </div>
            <div class="card-body">
                @if($stats['trafficSources']->isNotEmpty())
                    <canvas id="sourcesChart" height="250"></canvas>
                @else
                    <p class="text-muted">Данные о источниках трафика отсутствуют</p>
                @endif
            </div>
        </div>
    </div>
</div> <!-- Закрываем row -->

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Проверяем данные
    console.log('Revenue Data:', @json($stats['revenueByMonth']));

    // 1. График доходов
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['revenueByMonth']->keys()),
                datasets: [{
                    label: 'Доход (₽)',
                    data: @json($stats['revenueByMonth']->values()),
                    backgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // 2. График кликов
    const clicksCtx = document.getElementById('clicksChart');
    if (clicksCtx) {
        new Chart(clicksCtx, {
            type: 'line',
            data: {
                labels: @json($stats['clicksLast30Days']->keys()),
                datasets: [{
                    label: 'Клики',
                    data: @json($stats['clicksLast30Days']->values()),
                    borderColor: '#1cc88a',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // 3. Источники трафика
    const sourcesCtx = document.getElementById('sourcesChart');
    if (sourcesCtx) {
        new Chart(sourcesCtx, {
            type: 'doughnut',
            data: {
                labels: @json($stats['trafficSources']->keys()),
                datasets: [{
                    data: @json($stats['trafficSources']->values()),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
@endpush
