@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Редактировать Район</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.districts.update.store', $district->id)}}" method="post">
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
        <label for="name" class="form-label">Название района*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название района" value="{{$district->name}}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">Город*</label>
        <select id="city" name="city_id" class="form-select" aria-label="Default select example">
            @foreach($cities as $city)
            @if (old('city_id', $district->city_id) == $city->id)
                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
            @else
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>



@endsection