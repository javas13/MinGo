@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center">
    <h1>Редактировать кухню</h1>
</div>

<form id="categoryUpdateForm" class="mt-4" action="{{ route('admin.kitchens.update.store', $kitchen->id)}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Название категории*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{ $kitchen->name }}">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>



@endsection
