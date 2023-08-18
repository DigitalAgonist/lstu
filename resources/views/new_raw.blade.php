@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Добавление сырья @endsection

@section('content')

<div class="container py-5">
    <h1>Форма добавления сырья</h1>

    <div>
        <form action="{{ route('raw.upload') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="rawName">Наименование сырья</label>
              <input type="text" class="form-control" id="productName" name="name">
              <span class="text-danger "role="alert">@error ('name'){{ $message }} @enderror</span><br>
            </div>

            </div>
            <div class="form-group">
              <label for="rawDescription">Описание сырья</label>
              <textarea class="form-control" id="rawDescription" name="description" rows="3"></textarea>
              <span class="text-danger" role="alert">@error ('description'){{ $message }} @enderror</span><br>
            </div>
              <button type="submit" class="btn btn-primary">Сохранить</button>
          </form>
    </div>
</div>

@endsection
