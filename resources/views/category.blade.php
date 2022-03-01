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
    .product-price {
        border-bottom: 1px solid grey;
        font-size: 23px;
        text-align: center;
        margin-bottom: 10px;
    }
    .card-text {
        height: 46px;
    }
    .product-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-body {
        display: flex;
        flex-direction: column;
    }
    .card-text {
        flex-grow: 1;
    }
</style>
@endsection

@section('content')
<h1>{{ $categoryName }}</h1>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-3 mb-4">
            <div class="card">
                <div class="card-img p-4 pb-0">
                    <img src="{{ asset('storage') }}/{{$product->picture}}" class="card-img-top" alt="{{$product->name}}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        {{$product->name}}
                    </h5>
                    <p class="card-text">
                        {{ $product->description }}
                    </p>
                    <div class="product-price">
                        {{ $product->price }} руб.
                    </div>
                    <div class="product-buttons">
                        <form method="post" action="{{ route('removeFromCart')}}">
                            @csrf
                            <input name="id" hidden value="{{ $product->id }}">
                            <button @empty(session("cart.$product->id")) disabled @endempty class="btn btn-danger">-</button>
                        </form>
                        <div>{{ session("cart.$product->id") ?? 0 }}</div>
                        <form method="post" action="{{ route('addToCart')}}">
                            @csrf
                            <input name="id" hidden value="{{ $product->id }}">
                            <button class="btn btn-success">+</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection