@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Редактировать Город</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.cities.update.store', $city->id)}}" method="post">
    @csrf
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
        <input name="second_name" type="text" class="form-control" id="seoName" placeholder="second_name" value="{{$city->second_name}}">
    </div>
    <div class="mb-3">
        <label for="name_url" class="form-label">name_url</label>
        <input name="name_url" type="text" class="form-control" id="name_url" placeholder="name_url" value="{{$city->name_url}}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="population" class="form-label">Население</label>
        <input name="population" type="text" class="form-control" id="population" placeholder="Население" value="{{$city->population}}">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>



@endsection