@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Заказы @endsection

@section('content')

<div class="container py-5">
    @if(Auth::id() == $orders[0]->user->id)
    <h1>Мои заказы</h1>
    @else
    <h1>Заказы пользователя {{$orders[0]->user->name}}</h1>
    @endif
    <div class="text-center pt-3">
        @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session()->get('warning') }}
        </div>
    @endif
    </div>
    <br><br>
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th>#</th>
            <th>Дата</th>
            <th>Стоимость</th>
            <th>Статус</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @isset($orders)
            @foreach($orders as $order)
            <tr>
                <td>{{($orders->currentPage() - 1) * config('variable.paginate.table') + $loop->iteration}}</td>
                <td><span class="badge">{{$order->dateAndTime}}</span>

                </td>
                <td>{{$order->cost()}}</td>
                <td>
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
                </td>
                <td><a class="btn btn-primary px-5" href="{{route('orders.order', ['id' => $order->id])}}">Подробнее</a></td>
                <td>
                    @if($order->status == 2)
                    <form class="form-inline" action="{{route('order.confirm', ['id' => $order->id])}}" method="POST">
                        @csrf
                    <button type="submit" class="btn btn-success mb-2 px-5">Исполнено</button>
                  </form>
                  @endif
                </td>
            </tr>
        @endforeach

        <tr>
        </tr>
        @endisset
        </tbody>
    </table>
    <br>

    @include('layouts.paginator', ['data' => $orders])
</div>

@endsection
