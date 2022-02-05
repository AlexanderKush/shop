@extends('layouts.app')

@section('title')
    Профиль
@endsection

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

    <form method="post" action="{{ route('saveProfile') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name="userId">
        <div class="mb-3">
            <label class="form-label">Изображение</label>
            <div class="user-picture mb-2">
                <img class="user-picture__this" src="{{ asset('storage') }}/{{ $user->picture }}">
            </div>
            <input type="file" name="picture" value="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов</label>
            @forelse ($user->addresses as $address)
                <li @if($address->main)class="fw-bold"@endif>{{ $address->address }}</li>
            @empty
                <li><em>Список адресов пуст</em></li>
            @endforelse
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input type="text" name="new_address" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

@endsection