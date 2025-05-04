@extends('layouts.main')

@section('title', 'Home')

@section('content')

    {{-- <div class="row page-pad-top">
        <div class="col-md-6 offset-md-3">
            <h1>Регистрация</h1>

            <form action="{{route('user.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Имя" value="{{old('name')}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email')}}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Пароль">
                    @error('password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Повторите пароль</label>
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Повторите пароль">
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a class="ms-3" href="/login">Уже зарегистрированы?</a>
            </form>
        </div>
    </div> --}}

    <div class="container auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Создайте аккаунт</h2>
                <p>Присоединяйтесь к MinGO уже сегодня</p>
            </div>

            <form action="{{route('user.store')}}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Введите ваше имя" name="name" value="{{old('name')}}" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Введите ваш email" name="email" value="{{old('email')}}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label @error('password') is-invalid @enderror">Пароль</label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="password" placeholder="Создайте пароль" name="password" value="{{old('password')}}" required>
                        <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirmPassword" class="form-label">Подтверждение пароля</label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Повторите пароль" name="password_confirmation" required>
                        <i class="fas fa-eye password-toggle-icon" id="toggleConfirmPassword"></i>
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

                <button type="submit" class="btn btn-primary mb-4">Зарегистрироваться</button>

                <div class="login-link">
                    Уже есть аккаунт? <a href="/login">Войти</a>
                </div>
            </form>
        </div>
    </div>
@endsection
