@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Добавить Округ</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.districts.add.store')}}" method="post">
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
        <label for="name" class="form-label">Название округа*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название округа" value="{{old('name')}}">
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
            @if ($loop->first)
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}selected>{{ $city->name }}</option>
            @else
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>



@endsection