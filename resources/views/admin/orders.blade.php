@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - История заказов@endsection

@section('content')

<div class="container py-5">
    <h1>История заказов</h1>
    <div class="text-center pt-3">
        @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session()->get('warning') }}
        </div>
    @endif
    </div>

    <div>
        <form class="form" action="{{route('orders.filter')}}" method="GET">
            <div class="row">
                <div class="col">
                    <label for="dateBegin">Дата начала</label>
                    <input type="date" class="form-control" id="dateBegin" name="dateBegin">
                </div>
                <div class="col">
                    <label for="dateEnd">Дата окончания</label>
                    <input type="date" class="form-control" id="dateEnd" name="dateEnd">
                </div>
            </div>
            <hr class="my-4">
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="ordered" name="status" value="1" {{ old('ordered') ? 'checked' : '' }}>
                <label class="custom-control-label" for="ordered">Заказанные</label>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="completed" name="status" value="2" {{ old('completed') ? 'checked' : '' }}>
                <label class="custom-control-label" for="completed">Выполненные</label>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="closed" name="status" value="3" {{ old('closed') ? 'checked' : '' }}>
                <label class="custom-control-label" for="closed">Закрытые</label>
            </div>

        <button type="submit" class="btn btn-primary mb-2 mt-5">Показать</button>
      </form>
    </div>

    <br><br>
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th>#</th>
            <th>Заказчик</th>
            <th>Дата и время</th>
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
                <td>{{$order->user->name}}</td>
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
                    @if($order->status == 1)
                    <form class="form-inline" action="{{route('order.complete', ['id' => $order->id])}}" method="POST">
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

    @include('layouts.paginator', ['data' => $orders->withQueryString()])
</div>

@endsection
