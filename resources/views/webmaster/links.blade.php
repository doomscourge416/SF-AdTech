@extends('layouts.app')
@section('title', 'Мои ссылки')
@section('content')

    <h1>Мои аффилиатные ссылки</h1>

    @if(count($links) > 0)
        <ul class="list-group mb-4">
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
    @else
        <p>Вы ещё ни на какие офферы не подписаны</p>
    @endif

    <div class="mt-5 border p-3">
        <h3>Ваша статистика:</h3>
        <div style="height: 400px; background-color: #f8f9fa;" class="d-flex align-items-center justify-content-center">
            <canvas id="webmasterStatsChart" style="width: 100%; height: 100%"></canvas>
            <div id="chartFallback" class="text-muted">График загружается...</div>
        </div>
    </div>

    <a href="/webmaster" class="btn btn-primary mt-4">Подписаться на новый оффер</a>
    <a href="/logout" class="btn btn-danger mt-4">Выйти из аккаунта</a>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData ?? []);

            if (!chartData || chartData.length === 0) {
                document.getElementById('chartFallback').innerHTML = 'Нет данных для отображения';
                return;
            }

            const ctx = document.getElementById('webmasterStatsChart');

            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.map(item => item.label),
                        datasets: [{
                            label: 'Клики',
                            data: chartData.map(item => item.clicks),
                            backgroundColor: chartData.map(item => item.color || '#4bc0c0'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });

                document.getElementById('chartFallback').style.display = 'none';
            }
        });
    </script>
@endsection
