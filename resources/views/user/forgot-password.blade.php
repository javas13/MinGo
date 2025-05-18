@extends('layouts.main')

@section('title', 'Восстановление пароля - MinGo')
@section('canonical', 'https://mingonow.ru/forgot-password')
@section('ogTitle', 'Восстановление пароля - MinGo')

@section('title', 'Home')

@section('content')
    {{-- <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Восстановление пароля</h1>

            <form action="{{route('password.email')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">Восстановить</button>

            </form>
        </div>
    </div> --}}

    <div class="container auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Восстановление пароля</h2>
            </div>

            <form action="{{route('password.email')}}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Введите ваш email" name="email" value="{{old('email')}}" required>
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

                <button type="submit" class="btn btn-primary mb-4">Восстановить</button>

                <div class="login-link">
                    Вспомнили пароль? <a href="/login">Войти</a>
                </div>
            </form>
        </div>
    </div>
@endsection
