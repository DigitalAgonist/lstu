@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Редактирование продукта @endsection

@section('content')

<div class="container py-5">
    <h1>Форма редактирования продукта</h1>

    <div>
        <form action="{{ route('product.edit', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="productName">Наименование продукта</label>
              <input type="text" class="form-control" id="productName" name="name" value="{{$product->name}}">
              <span class="text-danger" role="alert">@error ('name'){{ $message }} @enderror</span><br>
            </div>
            </div>
            <div class="form-group">
              <label for="productDescription">Описание продукта</label>
              <textarea class="form-control" id="productDescription" name="description" rows="3">{{$product->description}}</textarea>
              <span class="text-danger" role="alert">@error ('description'){{ $message }} @enderror</span><br>
            </div>
            <div class="form-group">
                <label for="productPrice">Цена продукта</label>
                <input type="text" class="form-control" id="productPrice" name="price" value="{{$product->price}}">
                <span class="text-danger" role="alert">@error ('price'){{ $message }} @enderror</span><br>
              </div>
              <div class="form-group form-inline">
                <label for="productPicture">Карточка продукта</label>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="card my-5" style="width: 100%;">
                        <img src="{{Storage::url($product->picture)}}" class="card-img-top" alt="{{$product->name}}">
                    </div>
                </div>

                <input type="file" class="form-control-file" id="productPicture" name="image">
                <span class="text-danger" role="alert">@error ('image'){{ $message }} @enderror</span><br>
              </div>
              <button type="submit" class="btn btn-primary">Сохранить</button>
          </form>

          <br><br><br>

          <h3>Состав продукта</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Масса</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product->raws as $raw)
                <tr>
                    <td>{{@$loop->iteration}}</td>
                    <td>{{$raw->name}}</td>
                    <td>{{$raw->pivot->weight_g}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br><br>

    <h3 class="mb-3">Редактировать состав продукта</h3>
    <span class="text-danger" role="alert">@error ('weight'){{ $message }} @enderror</span><br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($raws as $raw)
            <tr>
                <td>{{$raw->id}}</td>
                <td>{{$raw->name}}</td>
                <td>
                    <form class="form-inline" action="{{route('product.setcomponent', ['productId' =>$product->id, 'rawId' => $raw->id])}}" method="POST">
                        @csrf
                        <div class="form-group mx-sm-3 mb-2">
                      <label for="inputPassword2" class="sr-only"></label>
                      <input type="text" class="form-control" name="weight" placeholder="Масса, грамм" value="{{old('weight')}}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Применить</button>
                  </form>
            </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection
