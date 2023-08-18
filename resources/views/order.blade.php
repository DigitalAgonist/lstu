@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Заказ №{{$order->id}} @endsection

@section('content')
@isset($order)
    <div class="container py-5">

        <div class="text-info py-3">
            <h1>Заказ № {{$order->id}}</h1>
            <span>Дата и время: {{$order->dateAndTime}}</span><br>
            @if($order->preorder != null)
            <span>Предзаказ на: {{$order->preorder}}</span><br>
            @endif
            @if($order->commentary != null)
            <span>Комментарий: {{$order->commentary}}</span><br>
            @endif
            <span>Статус:
                @switch($order->status)
                    @case(1)
                        Заказано
                        @break

                    @case(2)
                        Выполнено
                        @break

                    @case(3)
                        Закрыто
                        @break

                    @default

                @endswitch
            </span><br>
        </div>

        <div class="text-center pt-3">
            @if(session()->has('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div>
        @endif
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
                @foreach($order->products as $products)
                <tr>
                    <td>
                        <a href="{{ route('product.detail', ['id' => $products->id]) }}">
                            <img height="56px" src="/storage/{{$products->picture}}">
                           {{$products->name}}
                        </a>
                    </td>
                    <td><span class="badge">{{$products->pivot->quantity}}</span></td>
                    <td>{{$products->price}}</td>
                    <td>{{$products->price * $products->pivot->quantity}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Итоговая стоимость</td>
                <td>{{$order->cost()}}</td>
            </tr>
            </tbody>

        </table>
    </div>
@endisset
@endsection
