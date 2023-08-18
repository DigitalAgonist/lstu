@extends('layouts.master')

@section('title') {{env('APP_NAME')}} - Пользователи @endsection

@section('content')

    <div class="container py-5">
        <h1 class="pb-3">Профили</h1>

        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>E-mail</th>
                <th>Дата регистрации</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>

                    <td><span class="badge">{{$user->id}}</span></td>
                    <td>
                        <a href="{{ route('profile', ['id' => $user->id]) }}">
                            <img height="56px" src="{{Storage::url($user->avatar)}}">
                           {{$user->name}}
                        </a>
                    </td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @include('layouts.paginator', ['data' => $users])
@endsection
