@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Прогнозирование @endsection

@section('content')
<div class="container m-20 p-20">

    <div class="text-center pt-5">
        @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session()->get('warning') }}
        </div>
    @endif
    </div>

    <div>
        <form class="form" action="{{route('forecasting')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="dateBegin">Дата начала</label>
                    <input type="date" class="form-control" id="dateBegin" name="dateBegin" @if(isset($_POST['dateBegin'])) value="{{$_POST['dateBegin']}}" @endif>
                </div>
                <div class="col">
                    <label for="dateEnd">Дата окончания</label>
                    <input type="date" class="form-control" id="dateEnd" name="dateEnd" @if(isset($_POST['dateEnd'])) value="{{$_POST['dateEnd']}}" @endif>
                </div>
            </div>
        <button type="submit" class="btn btn-primary mb-2 mt-5">Получить прогноз</button>
      </form>
    </div>


    @isset($products)
    <div class="my-5">
        <h3>Продукция</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @if ($product->count != 0)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{ceil($product->count)}}</td>
                    <td>{{$product->price}}</td>
                </tr>
                @endif
            @endforeach
            </tbody>

        </table>
    </div>
    @endisset

    @isset($raws)
    <div class="my-5">
        <h3>Сырьё</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Масса, кг</th>

            </tr>
            </thead>
            <tbody>
                @foreach($raws as $raw)
                @if ($raw->weight != 0)
                <tr>
                    <td>{{$raw->name}}</td>
                    <td>{{ceil($raw->weight/1000)}}</td>
                </tr>
                @endif
            @endforeach
            </tbody>

        </table>
    </div>
    @endisset

</div>

@endsection
