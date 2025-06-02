@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Добавить Рекламную камнанию</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.adverts.add.store')}}" method="post">
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
        <label for="place_id" class="form-label">ID Места*</label>
        <input name="place_id" type="text" class="form-control @error('place_id') is-invalid @enderror" id="place_id" placeholder="ID Места" value="{{old('place_id')}}">
        @error('place_id')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="type_id" class="form-label">Тип рекламы*</label>
        <select id="type_id" name="type_id" class="form-select" aria-label="Default select example">
            @foreach($advertsTypes as $elem)
            @if ($loop->first)
                <option value="{{ $elem->id }}" {{ old('type_id') == $elem->id ? 'selected' : '' }}selected>{{ $elem->name }}</option>
            @else
                <option value="{{ $elem->id }}" {{ old('type_id') == $elem->id ? 'selected' : '' }}>{{ $elem->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="starts_at" class="form-label">Дата начала кампании*</label>
        <input class="form-control" name="starts_at" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}" value="{{ date('Y-m-d') }}" type="date">
    </div>
    <div class="mb-3">
        <label for="starts_end" class="form-label">Дата конца кампании*</label>
        <input class="form-control" name="ends_at" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+31 days')) }}" value="{{ date('Y-m-d', strtotime('+7 days')) }}" type="date">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>



@endsection