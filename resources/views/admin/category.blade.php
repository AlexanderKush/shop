@extends('layouts.app')

@section('styles')
    <style>
        .user-picture {
            width: 100px;
            height: 100px;
            border-radius: 50rem;
            overflow: hidden;
        }
        .user-picture__this {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
@endsection

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

    @if (session('profileSaved'))
        <div class="alert alert-success" role="alert">
            Категория успешно сохранена!
        </div>
    @endif

    <h1>{{ $category->name }}</h1>

    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $category->id }}" name="userId">
        <div class="mb-3">
            <label class="form-label">Изображение</label>
            <div class="user-picture mb-2">
                <img class="user-picture__this" src="{{ asset('storage') }}/{{ $category->picture }}">
            </div>
            <input type="file" name="picture" value="" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <input type="text" name="description" value="{{ $category->description }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

@endsection