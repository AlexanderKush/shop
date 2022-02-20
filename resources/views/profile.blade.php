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
    @if (session('profileSaved'))
        <div class="alert alert-success" role="alert">
            Профиль успешно сохранён!
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
            <label class="form-label">Текущий пароль</label>
            <input type="password" name="current_password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input type="password" name="password_new" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Повторите новый пароль</label>
            <input type="password" name="password_new_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов</label>
            @forelse ($user->addresses as $address)
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="address_{{ $address->id }}" name="address" @if ($address->main)checked @endif value="{{ $address->id }}">
                    <label class="form-check-label" for="address_{{ $address->id }}">{{ $address->address }}</label>
                </div>
            @empty
                <div>
                    Список адресов пуст
                </div>
            @endforelse
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input type="text" name="new_address" class="form-control">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="new_address_main">
            <label class="form-check-label">Сделать новый адрес основным</label> 
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

    <br>
    <br>
    <h2>История заказов</h2>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>#</th>
                <th class="w-25">Адрес</th>
                <th>Товары</th>
                <th>Сумма заказа</th>
                <th>Дата</th>
                <th></th>
            </tr>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <ul>
                            @foreach ($order->products as $product)
                                <li>{{ $product->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @php
                            $summ = 0;
                        @endphp
                        @foreach ($order->products as $product)
                            @php
                                $productSumm = $product->pivot->price * $product->pivot->quantity;
                                $summ += $productSumm;
                            @endphp
                        @endforeach
                        {{ $summ }} руб.
                    </td>
                    <td>{{ $order->created_at }}</td>
                    <td class="text-center">
                        <form method="post" action="{{ route('repeatOrder')}}">
                            @csrf
                            <button type="submit"class="btn btn-primary">
                                <input type="hidden" name="id" value="{{ $order->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"></path>
                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"></path>
                                </svg>
                                Повторить заказ
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Список заказов пуст</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection