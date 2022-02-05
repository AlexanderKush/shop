@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')

    <ul>
        <li><a href="{{ route('adminUsers') }}">Список пользователей</a></a></li>
        <li><a href="{{ route('adminProducts') }}">Список продуктов</a></a></li>
        <li><a href="{{ route('adminCategories') }}">Список категорий</a></a></li>
    </ul>

@endsection