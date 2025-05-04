@extends('layouts.main')

@section('title', 'Home')

@section('content')
    {{-- <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Login form</h1>

            <form action="{{route('login.auth')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" value="{{old('name')}}" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="mb-3 form-check">
                    <input name="remember" class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">
                        Запомнить меня
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

                <a class="ms-2" href="{{route('password.request')}}">Забыли пароль?</a>
            </form>
        </div>
    </div> --}}

    <div class="container auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Вход в аккаунт</h2>
            </div>

            <form action="{{route('login.auth')}}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Введите ваш email" value="{{old('email')}}" required>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Создайте пароль" value="{{old('password')}}" required>
                        <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="reset-link mb-3">
                    Забыли пароль? <a href="{{ route('password.request') }}">Восстановить</a>
                </div>

                <button type="submit" class="btn btn-primary mb-4">Войти</button>

                <div class="login-link">
                    Нет аккаунта? <a href="/register">Регистрация</a>
                </div>
            </form>
        </div>
    </div>
@endsection
