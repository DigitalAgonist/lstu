@extends('layouts.master')

@section('content')
@section('title') {{env('APP_NAME')}} - Добавление продукта @endsection

<div class="container py-5">
    <h1>Форма добавления продукта</h1>

    <div>
        <form action="{{ route('product.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="productName">Наименование продукта</label>
              <input type="text" class="form-control" id="productName" name="name" value="{{ old('name') }}">
              <span class="text-danger" role="alert">@error ('name'){{ $message }} @enderror</span><br>
            </div>
            </div>
            <div class="form-group">
              <label for="productDescription">Описание продукта</label>
              <textarea class="form-control" id="productDescription" name="description" rows="3">{{ old('description') }}</textarea>
              <span class="text-danger" role="alert">@error ('description'){{ $message }} @enderror</span><br>
            </div>
            <div class="form-group">
                <label for="productPrice">Цена продукта</label>
                <input type="text" class="form-control" id="productPrice" name="price"  value="{{ old('price') }}">
                <span class="text-danger" role="alert">@error ('price'){{ $message }} @enderror</span><br>
              </div>
              <div class="form-group">
                <label for="productPicture">Карточка продукта</label>
                <input type="file" class="form-control-file" id="productPicture" name="image">
                <span class="text-danger" role="alert">@error ('image'){{ $message }} @enderror</span><br>
              </div>
              <button type="submit" class="btn btn-primary">Сохранить</button>
          </form>
    </div>
</div>



@endsection
