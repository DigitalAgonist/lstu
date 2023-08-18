@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Главная @endsection

@section('search')

<form class="form-inline my-2 my-lg-0" action="{{route('filter')}}" method="get">
    <input class="form-control mr-sm-2"  name="search" @if(isset($_GET['search'])) value="{{$_GET['search']}}" @endif type="text" placeholder="Найти" id="text-to-find" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0 button_for_search" type="submit">Найти</button>
  </form>

@endsection

@section('content')

<div class="container m-20 p-20">

    <div class="text-center pt-5">
        @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session()->get('warning') }}
        </div>
    @endif
    </div>

    <div class="row text-center justify-content-center">
        @foreach ($data as $element)
        <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="card my-5" style="width: 100%;">
                    <img src="{{Storage::url($element->picture)}}" class="card-img-top" alt="{{$element->name}}">
                    <div class="card-body ">
                        <h5 class="card-title">{{$element->name}}</h5>
                        <p class="card-text">{{$element->price}} ₽</p>

                        <div class="btn-group">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('product.detail', ['id' => $element->id]) }}">Подробнее</a>
                            @auth
                                <form action="{{ route('basket.add', ['id' => $element->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">В корзину</button>
                                </form>

                                @if (Auth::user()->role_id == 3)
                                    <a href=" {{route('product.edit', ['id' => $element->id])}} " class="btn btn-sm btn-outline-secondary">Редактировать</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('layouts.paginator', ['data' => $data->withQueryString()])
</div>

@endsection
