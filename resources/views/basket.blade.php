@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Корзина @endsection

@section('content')

    <div class="container py-5">

        <h1>Корзина</h1>
        <div class="text-center pt-3">
            @if(session()->has('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div>
        @endif
        </div>

        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
                @isset($order)
                @foreach($order->products as $products)
                <tr>
                    <td>
                        <a href="{{ route('product.detail', ['id' => $products->id]) }}">
                            <img height="56px" src="{{Storage::url($products->picture)}}">
                           {{$products->name}}
                        </a>
                    </td>
                    <td><span class="badge">{{$products->pivot->quantity}}</span>
                        <div class="btn-group form-inline">
                            <form action="{{ route('basket.rm', ['id' => $products->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" href=""><span
                                        class="glyphicon glyphicon-minus" aria-hidden="true"></span>-</button>
                            </form>
                            <form action="{{ route('basket.add', ['id' => $products->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success"
                                        href=""><span
                                        class="glyphicon glyphicon-plus" aria-hidden="true"></span>+</button>
                            </form>
                        </div>
                    </td>
                    <td>{{$products->price}}</td>
                    <td>{{$products->price * $products->pivot->quantity}}</td>
                </tr>
            @endforeach



            <tr>
                <td colspan="3">Итоговая стоимость</td>
                <td>{{$order->cost()}}</td>
            </tr>
            @endisset
            </tbody>

        </table>


        <br><br>

        <div>
            <form class="form" action="{{route('basket.order')}}" method="POST">
                @csrf
            <div class="form-group">
                <label for="date">Дата</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Дата">
              </div>
              <div class="form-group">
                <label for="commentary">Комментарий</label>
                <textarea class="form-control" id="commentary" name="commentary" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary mb-2">Заказать</button>
          </form>
        </div>
    </div>

@endsection
