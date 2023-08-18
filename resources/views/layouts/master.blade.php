<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>@yield('title')</title>
</head>
<body>

<style>
    html,
    body {
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    footer {
      flex: 0 0 auto;
    }
    </style>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="{{ route('index') }}">КЦЛГТУ</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('index') }}">Главная <span class="sr-only">(current)</span></a>
      </li>
      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Войти</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">Зарегистрироваться</a>
      </li>
      @endguest
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{Auth::user()->name}}
          <img src="/storage/{{Auth::user()->avatar}}" class="rounded-circle px-1"
            height="22" alt="Avatar" loading="lazy" />
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('profile', ['id' => Auth::id()]) }}">Мой профиль</a>
          <a class="dropdown-item" href="{{route('orders.user', ['id' => Auth::id()])}}">Мои заказы</a>
          <a class="dropdown-item" href="{{route('basket')}}">Моя корзина</a>
          @if(Auth::user()->role_id > 1)
          <a class="dropdown-item" href="{{route('orders.admin')}}">История заказов</a>
          <a class="dropdown-item" href="{{route('forecasting')}}">Прогнозирование</a>
          <a class="dropdown-item" href="{{route('profiles')}}">Пользователи</a>
          @endif
          @if(Auth::user()->role_id == 3)
          <a class="dropdown-item" href="{{ route('product.create') }}">Добавление продукта</a>
          <a class="dropdown-item" href="{{ route('raw.create') }}">Добавление сырья</a>
          <a class="dropdown-item" href="{{ route('raws') }}">Список сырья</a>
          <a class="dropdown-item" href="{{route('profiles.control')}}">Управление пользователями</a>
          @endif
          <div class="dropdown-divider"></div>
          <div class="dropdown-item">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="btn btn-link btn-block dropdown-item text-left p-0" type="submit" role="button">Выйти</button>
            </form>
          </div>
        </div>
      </li>
      @endauth
    </ul>

    @yield('search');

    @if (!array_key_exists('search', View::getSections()));
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Найти" id="text-to-find" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0 button_for_search" type="submit" onclick="javascript: FindOnPage('text-to-find',true); return false;" value=" " title="Начать поиск">Найти</button>
        </form>
    @endif

  </div>
</nav>


@yield('content')

<footer class="footer mt-auto py-3 bg-dark">
    <p class="text-muted text-center">WEB-приложение «Кондитерский цех ЛГТУ» разарботано в рамках преддипломной практики студентом группы АИ-19 Первушиным Олегом Сергеевичем</p>
  <div class="container">
    <p class="text-muted text-center">&copy Первушин О. С. 2023 г.</p>
  </div>
</footer>


</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        var input,search,pr,result,result_arr, locale_HTML, result_store;

        function func() {
            locale_HTML = document.body.innerHTML;   // сохраняем в переменную весь body (Первоначальный)
        }
        setTimeout(func, 1000);  //ждем подгрузки Jsona и выполняем

        function FindOnPage(name, status) {

            input = document.getElementById(name).value; //получаем значение из поля в html

            if(input.length<3&&status==true)
            {
                alert('Для поиска вы должны ввести три или более символов');
                function FindOnPageBack() { document.body.innerHTML = locale_HTML; }
            }

            if(input.length>=3)
            {
                function FindOnPageGo() {

                    search = '/'+input+'/g';  //делаем из строки регуярное выражение
                    pr = document.body.innerHTML;   // сохраняем в переменную весь body
                    result = pr.match(/>(.*?)</g);  //отсекаем все теги и получаем только текст
                    result_arr = [];   //в этом массиве будем хранить результат работы (подсветку)

                    var warning = true;
                    for(var i=0;i<result.length;i++) {
                        if(result[i].match(eval(search))!=null) {
                            warning = false;
                        }
                    }
                    if(warning == true) {
                        alert('Не найдено ни одного совпадения');
                    }

                    for(var i=0; i<result.length;i++) {
                        result_arr[i] = result[i].replace(eval(search), '<span style="background-color:yellow;">'+input+'</span>'); //находим нужные элементы, задаем стиль и сохраняем в новый массив
                    }
                    for(var i=0; i<result.length;i++) {
                        pr=pr.replace(result[i],result_arr[i])  //заменяем в переменной с html текст на новый из новогом ассива
                    }
                    document.body.innerHTML = pr;  //заменяем html код
                }
            }
            function FindOnPageBack() { document.body.innerHTML = locale_HTML; }
            if(status) { FindOnPageBack(); FindOnPageGo(); } //чистим прошлое и Выделяем найденное
            if(!status) { FindOnPageBack(); } //Снимаем выделение
        }

    </script>
</body>
</html>
