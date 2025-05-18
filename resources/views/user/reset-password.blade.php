@extends('layouts.main')

@section('title', 'Сброс пароля - MinGo')
@section('ogTitle', 'Сброс пароля - MinGo')

@section('title', 'Home')

@section('content')
    {{-- <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Установите новый пароль</h1>

            <form action="{{route('password.update')}}" method="post">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

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
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div> --}}

    <div class="container auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Установите новый пароль</h2>
            </div>

            <form action="{{route('password.update')}}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
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

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
 
                <button type="submit" class="btn btn-primary mb-4">Сохранить</button>

            </form>
        </div>
    </div>
@endsection
