@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Сырьё @endsection

@section('content')

<div class="container py-5">
    <h1>Список сырья</h1>
    <div class="pt-5">
        <table class="table table-striped ">
            <thead>
            <tr>
                <th>#</th>
                <th>
                    <form class="form-inline">
                        <div class="form-group mr-sm-5 px-3 pr-5">
                            <label class="">Наименование</label>
                        </div>
                        <div class="form-group mr-sm-5 px-4">
                            <label class="px-5">Описание</label>
                        </div>

                      </form>
                </th>

            </tr>
            </thead>
            <tbody>
                @isset($raws)
                @foreach($raws as $raw)
                <tr>
                    <td>{{($raws->currentPage() - 1) * config('variable.paginate.table') + $loop->iteration}}</td>
                    <td colspan="3">
                        <form action="{{route('raw.update', ['id' => $raw->id])}}" class="form-inline" method="POST">
                            @csrf
                            <div class="form-group mr-sm-5 my-3 px-3">
                              <input type="text" class="form-control" id="name" name="name" value="{{$raw->name}}">
                            </div>
                            <div class="form-group mr-sm-5 my-3 px-3">
                              <input type="text" class="form-control " id="description" name="description" value="{{$raw->description}}">
                            </div>
                            <button type="submit" class="btn btn-primary mr-sm-5 my-3 px-3">Сохранить изменения</button>
                          </form>
                    </td>
                </tr>
            @endforeach
            <tr></tr>
            @endisset
            </tbody>
        </table>
        @include('layouts.paginator', ['data' => $raws->withQueryString()])
    </div>
</div>

@endsection
