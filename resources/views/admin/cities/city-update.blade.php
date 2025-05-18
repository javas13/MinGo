@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Редактировать Город</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.cities.update.store', $city->id)}}" method="post">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Название города (Москва)</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название города" value="{{$city->name}}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="second_name" class="form-label">Второе название (Москве)</label>
        <input name="second_name" type="text" class="form-control" id="second_name" placeholder="second_name" value="{{$city->second_name}}">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>



@endsection