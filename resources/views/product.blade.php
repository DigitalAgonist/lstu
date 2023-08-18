@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - {{$product->name}} @endsection

@section('content')
<div class="container m-20 p-20">
    <div class="row text-center justify-content-center">



    <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card my-5" style="width: 100%;">
                <img src="{{Storage::url($product->picture)}}" class="card-img-top" alt="{{$product->name}}">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{$product->description}}</p>
                    <p class="card-text">{{$product->price}} рублей</p>

                    <h3>Состав продукта</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Наименование</th>
                                @auth
                                    @if (Auth::user()->role_id > 1)
                                        <th>Масса, г</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->raws as $raw)
                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{$raw->name}}</td>
                                    @auth
                                        @if (Auth::user()->role_id > 1)
                                            <td>{{$raw->pivot->weight_g}}</td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @auth
    <p>
        <form action="{{ route('basket.add', ['id' => $product->id]) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">В корзину</button>
            @if (Auth::user()->role_id == 3)
                <a href=" {{route('product.edit', ['id' => $product->id])}} " class="btn btn-primary">Редактировать</a>
            @endif
        </form>
    </p>
    @endauth
</div>


@endsection
