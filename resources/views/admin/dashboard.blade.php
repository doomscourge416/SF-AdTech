@extends('layouts.app')
@section('title', 'Панель администратора')
@section('content')
    <p>Добро пожаловать, {{ auth()->user()->name }}</p>

    <div class="row">
        <div class="col-md-6">
            <h3>На модерации</h3>
            <table class="table table-bordered">
                <tr><th>ID</th><th>Имя</th><th>Email</th><th>Роль</th></tr>
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
        </div>

        <div class="col-md-6">
            <h3>Активные пользователи</h3>
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
        </div>
    </div>
@endsection
