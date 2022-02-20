@extends('layouts.app')

@section('styles')
<style>
    .card {
        height: 100%;
    }
    .card-img {
        text-align: center;
    }
    .card-img img {
        max-height: 100px;
        width: auto;
    }
</style>
@endsection

@section('content')
<div class="row">

    @foreach ($categories as $category)
    <div class="col-4 mb-4">
        <div class="card">
            <div class="card-img p-4 pb-0">
                <img src="{{ asset('storage') }}/{{ $category->picture }}" class="card-img-top" alt="{{ $category->name }}">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $category->name }}</h5>
                <p class="card-text">{{ $category->description }}</p>
                <a href="{{ route('category', $category->id) }}" class="btn btn-primary">Перейти</a>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection