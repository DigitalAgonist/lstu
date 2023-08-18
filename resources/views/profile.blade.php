@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - {{$user->name}} @endsection
@section('content')

    <div class="container p-5">
        <div class="row text-center item-center">
            <div class="col-md-12 mb-12 mb-md-12">
              <div class="card ">
                <div class="card-up" style="background-color: #9d789b;"></div>
                <div class="avatar mx-auto bg-white">
                  <img src="{{Storage::url($user->avatar)}}"
                    class="rounded-circle img-fluid" />
                </div>
                <div class="card-body">
                  <h4 class="mb-4">{{$user->name}}</h4>
                  <p class="dark-grey-text mt-4">Email: {{$user->email}}</p>
                  <hr />
                  <p class="dark-grey-text mt-4">Дата регистрации: {{$user->created_at}}</p>
                  <p class="dark-grey-text mt-4">Роль: {{$user->role->name}}</p>
                  @if(Auth::id() == $user->id || Auth::user()->role_id > 2)<p><a href="{{route('profile.data', ['id' => $user->id])}}">Изменить учетные данные</a></p>@endif
                  @if(Auth::user()->role_id > 1)<p><a href="{{route('orders.user', ['id' => $user->id])}}">Заказы пользователя</a></p>@endif
                  @if(Auth::user()->role_id > 2 && $user->id != Auth::id())
                  <table class="table table-striped table-responsive-md">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Роль</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                <form class="form-inline" action="{{route('profile.setrole', ['id' =>$user->id, 'roleId' => $role->id])}}" method="POST">
                                    @csrf
                                <button type="submit" class="btn btn-primary mb-2">Установить</button>
                              </form>
                        </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                  @endif
                  @if($user->id == Auth::id())
                    <hr />
                  <div class="text-left">
                    <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                          <div class="form-group">
                            <label class="inline" for="avatar">Загрузить фотографию профиля</label>
                            <input type="file" class="form-control-file" id="avatar" name="avatar">
                            <span class="text-danger" role="alert">@error ('avatar'){{ $message }} @enderror</span><br>
                          </div>
                          <button type="submit" class="btn btn-primary">Загрузить аватар</button>
                      </form>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
    </div>




@endsection
