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
    @if (session('productCreate'))
        <div class="alert alert-success">
            Товар добавлен
        </div>
    @endif
    @if (session('startExportProducts'))
        <div class="alert alert-success">
            Выгрузка товаров запущена
        </div>
    @endif

    <h1>Список продуктов</h1>

    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Изображение</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Категория</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="id">{{ $product->id }}</td>
                    <td class="image">
                        <img class="img-thumbnail" src="{{ asset('storage') }}/{{ $product->picture }}" class="card-img-top" alt="{{ $product->name }}">
                    </td>
                    <td class="name">
                        <a href="{{ route('adminProduct', $product->id) }}">{{ $product->name }}</a>
                    </td>
                    <td class="description">{{ $product->description }}</td>
                    <td class="price">{{ $product->price }}</td>
                    <td class="category">{{ $product->category['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <br>
    <h2>Добавить товар</h2>
    <form method="post" action="{{ route('createProduct') }}" enctype="multipart/form-data">
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
        <div class="mb-3">
            <label class="form-label">Цена</label>
            <input type="text" name="price" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Категория</label>
            <select name="category_id" class="form-control">
                <option disabled selected>-- Выберите категорию --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <br>
    <br>
    <h2>Экспорт товаров</h2>
    <form method="post" action="{{ route('exportProducts') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Выгрузить товары</button>
    </form>

    <br>
    <br>

@endsection