<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Title не указан')</title>
    @vite(['resources/libs/bootstrap/bootstrap.bundle.js', 'resources/libs/bootstrap/bootstrap.css', 'resources/css/admin-login.css'])
</head>
<body style="background-color: #bfbfbf;" class="position-relative">
{{-- <img class="logo-bf position-absolute w-auto" src="img/admin/logobf-transparent.png" alt=""> --}}
<div class="container">
    <div class="row justify-content-center">
        <div style="width: 400px" class="col-md-auto vh-100 d-flex">
            <div class="align-self-center p-3 w-100 login-form">
                <form action="{{route('admin.login')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" id="login">
                        @error('login')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control @error('login') is-invalid @enderror" id="password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input name="remember" class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">
                            Запомнить меня
                        </label>
                    </div>

                    <button type="submit" class="w-100 mb-2 btn btn-primary">Войти</button>

                    <a class="ms-1" href="{{route('password.request')}}">Забыли пароль?</a>
                </form>
            </div>
        </div>
    </div>

</div>

</body>
</html>
