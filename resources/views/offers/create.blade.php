@extends('layouts.app')

@section('title', 'Создать оффер')
@section('content')
    <h2>Создать новый оффер</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/offers">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Название оффера</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="target_url" class="form-label">Целевой URL</label>
            <input type="url" name="target_url" id="target_url" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="payout" class="form-label">Выплата за клик (руб.)</label>
            <input type="number" step="0.01" min="0.01" max="100" name="payout" id="payout" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить оффер</button>
    </form>
@endsection
