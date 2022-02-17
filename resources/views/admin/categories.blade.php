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
    @if (session('categoryCreate'))
        <div class="alert alert-success">
            Категория добавлена
        </div>
    @endif
    @if (session('startExportCategories'))
        <div class="alert alert-success">
            Выгрузка категорий запущена
        </div>
    @endif

    <h1>Список категорий</h1>

    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование</th>
            <th>Описание</th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="id">{{ $category->id }}</td>
                    <td class="image">
                        <img class="img-thumbnail" src="{{ asset('storage') }}/{{ $category->picture }}" class="card-img-top" alt="{{ $category->name }}">
                    </td>
                    <td class="name">
                        <a href="{{ route('adminCategory', $category->id) }}">{{ $category->name }}</a>
                    </td>
                    <td class="description">{{ $category->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <br>
    <h2>Добавить категорию</h2>
    <form method="post" action="{{ route('createCategory') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Изображение</label>
            <input type="file" name="picture" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <input type="text" name="description" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <br>
    <br>
    <h2>Экспорт категорий</h2>
    <form method="post" action="{{ route('exportCategories') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Выгрузить категории</button>
    </form>

    <br>
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

    <br>
    <br>

@endsection