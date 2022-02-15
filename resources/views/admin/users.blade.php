@extends('layouts.app')

@section('content')

    @if ($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
        </div>
    @endif

    <h1>
        {{ $title }}
    </h1>

    <h2>Роли</h2>
    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Название</th>
        </thead>
        <tbody>
            @forelse ($roles as $idx => $role)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $role->name }}</td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="2">Ролей пока нет</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <form method="post" action="{{route('addRole')}}" class="mb-4">
        <h3>Добавить новую роль</h3>
        @csrf
        <input class="form-control mb-2" name='name'>
        <button class="btn btn-success" type="submit">Сохранить</button>
    </form>

    <form method="post" action="{{route('addRoleToUser')}}" class="mb-4">
        <h3>Добавить роль пользователю</h3>
        @csrf
        <select class="form-control mb-2" name='user_id'>
            <option disabled selected>-- Выберите пользователя --</option>
            @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
        <select class="form-control mb-2" name='role_id'>
            <option disabled selected>-- Выберите роль --</option>
            @foreach ($roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>
        <button class="btn btn-success" type="submit">Сохранить</button>
    </form>

    <h2>Пользователи</h2>
    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Имя</th>
            <th>Почта</th>
            <th>Роли</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('enterAsUser', $user->id) }}">Войти</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('startExportCategories'))
    <div class="alert alert-success">
        Выгрузка категорий запущена
    </div>
    @endif

    <br>
    <h2>Экспорт категорий</h2>
    <form method="post" action="{{ route('exportCategories') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Выгрузить категории</button>
    </form>

    <br>
    <h2>Импорт категорий</h2>
    <form method="post" action="{{ route('exportCategories') }}">
        @csrf
        <div class="row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Загрузить категории</button>
            </div>
            <div class="col-8">
                <input type="file" class="form-control">
            </div>
    </form>

@endsection