@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
    <h1>Панель управления магазином Shop</h1>
    <div class="row">
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-img p-4 pb-0">
                    <img src="{{ asset('storage') }}/icons/people.svg" alt="Список пользователей" class="card-img-top card-img-top--min">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Список пользователей</h5>
                    <p class="card-text">Управление пользователями и ролями</p>
                    <a href="{{ route('adminUsers') }}" class="btn btn-primary">Перейти</a>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-img p-4 pb-0">
                    <img src="{{ asset('storage') }}/icons/card-list.svg" alt="Список продуктов" class="card-img-top card-img-top--min">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Список продуктов</h5>
                    <p class="card-text">Добавление, корректировки и удаление продуктов</p>
                    <a href="{{ route('adminProducts') }}" class="btn btn-primary">Перейти</a>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-img p-4 pb-0">
                    <img src="{{ asset('storage') }}/icons/folder.svg" alt="Список категорий" class="card-img-top card-img-top--min">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Список категорий</h5>
                    <p class="card-text">Добавление, корректировки и удаление категорий</p>
                    <a href="{{ route('adminCategories') }}" class="btn btn-primary">Перейти</a>
                </div>
            </div>
        </div>
    </div>

@endsection