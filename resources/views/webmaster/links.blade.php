@extends('layouts.app')
@section('title', 'Мои ссылки')
@section('content')

    <h1>Мои аффилиатные ссылки</h1>

    @if(count($links) > 0)
        <ul>
            @foreach($links as $link)
                <li>

                    {{ $link->offer->title }}
                    <a href="/go/{{ $link->token }}" target="_blank" class="btn btn-sm btn-success">
                        /go/{{ $link->token }}
                    </a>

                </li>
            @endforeach
        </ul>
    @else
        <p>Вы ещё ни на какие офферы не подписаны</p>
    @endif

    <div class="chart-wrapper" style="aspect-ratio: 2 / 1; max-width: 600px; margin: 0 auto;">
        <canvas id="webmasterEarnings" width="400" height="200"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('webmasterEarnings').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Оффер 1', 'Оффер 2', 'Оффер 3'],
                datasets: [{
                    label: 'Клики',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ]
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Клики по вашим ссылкам'
                    }
                }
            }
        });
        </script>
    </div>

    <a href="/webmaster" class="btn btn-secondary">Все офферы</a>
@endsection
