@extends('layouts.app')

@section('title', 'Статистика оффера')
@section('content')
    <h1>{{ $offer->title }}</h1>
    <p><strong>Целевой URL:</strong> {{ $offer->target_url }}</p>
    <p><strong>Выплата за клик:</strong> {{ $offer->payout }} руб.</p>

    <hr>

    <h2>Статистика</h2>
    <ul>
        <li>Клики за сегодня: {{ $todayClicks }}</li>
        <li>Клики за месяц: {{ $thisMonthClicks }}</li>
        <li>Клики за год: {{ $thisYearClicks }}</li>
        <li>Всего кликов: {{ $offer->total_clicks }}</li>
        <br>
        <li>Доход за сегодня: {{ $offer->today_clicks * $offer->payout }} руб.</li>
        <li>Доход за месяц: {{ $offer->this_month_clicks * $offer->payout }} руб.</li>
        <li>Доход за год: {{ $offer->this_year_clicks * $offer->payout }} руб.</li>
    </ul>
    <ul>
        <li>Доход системы за всё время: {{ $systemEarnings }} руб.</li>
        <li>Доход веб-мастера за всё время: {{ $webmasterEarnings }} руб.</li>

    </ul>

    <form method="GET" action="/offers/{{ $offer->id }}">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Показать статистику за выбранную дату</button>
    </form>


    <canvas id="offerStatsChart" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('offerStatsChart').getContext('2d');
        const offerStatsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Сегодня', 'Месяц', 'Год'],
                datasets: [{
                    label: 'Клики по офферу',
                    data: [
                        {{ $offer->today_clicks }},
                        {{ $offer->month_clicks }},
                        {{ $offer->year_clicks }}
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: { display: true },
                    title: {
                        display: true,
                        text: 'Статистика по переходам'
                    }
                }
            }
        });
    </script>

    <a href="/offers" class="btn btn-secondary">Назад к списку</a>
@endsection
