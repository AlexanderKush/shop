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
<div class="container">
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
                        <button class="btn btn-danger">-</button>
                        <div>0</div>
                        <button class="btn btn-success">+</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection