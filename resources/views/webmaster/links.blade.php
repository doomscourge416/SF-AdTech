@extends('layouts.app')

@section('title', 'Мои ссылки')

@section('content')
@php
    $chartData = $chartData ?? [];
@endphp

<div class="container">
    <h1 class="mb-4">Мои аффилиатные ссылки</h1>

    @if(count($links) > 0)
        <div class="card mb-4">
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($links as $link)
                        @php
                            $data = collect($chartData)->firstWhere('label', $link->offer->title);
                            $color = $data['color'] ?? '#E0E0E0';
                        @endphp
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span style="background-color: {{ $color }}; width: 20px; height: 20px; display: inline-block; border-radius: 4px;" class="me-3"></span>
                                <strong>{{ $link->offer->title }}</strong>
                            </div>
                            <a href="{{ url('/go/'.$link->token) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                /go/{{ $link->token }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <div class="alert alert-info">Вы ещё ни на какие офферы не подписаны</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">Статистика кликов</h3>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="performanceChart"></canvas>
                <div id="chartFallback" class="text-muted text-center py-4">Загрузка данных графика...</div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="/webmaster" class="btn btn-primary">Подписаться на новый оффер</a>
        <a href="/logout" class="btn btn-outline-danger">Выйти из аккаунта</a>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Получаем данные из PHP
    const chartData = @json($chartData);
    const ctx = document.getElementById('performanceChart');
    const fallback = document.getElementById('chartFallback');

    // Проверяем наличие данных и элемента canvas
    if (!ctx || !chartData || chartData.length === 0) {
        if (fallback) {
            fallback.textContent = 'Нет данных для отображения графика';
        }
        return;
    }

    // Скрываем fallback сообщение
    if (fallback) {
        fallback.style.display = 'none';
    }

    // Создаем график
    try {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(item => item.label),
                datasets: [{
                    label: 'Количество кликов',
                    data: chartData.map(item => item.value),
                    backgroundColor: chartData.map(item => item.color),
                    borderColor: chartData.map(item => item.color.replace('0.6', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        },
                        grid: {
                            display: true
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    } catch (e) {
        console.error('Ошибка при создании графика:', e);
        if (fallback) {
            fallback.textContent = 'Ошибка при отображении графика';
            fallback.style.display = 'block';
        }
    }
});
</script>
@endsection
