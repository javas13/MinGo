@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center">
    <h1>Редактировать категорию</h1>
</div>

<form id="categoryUpdateForm" class="mt-4" action="{{ route('admin.category.update.store', $category->id)}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Название категории*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{ $category->name }}">
    </div>
    <div class="mb-3">
        <label for="sortOrder" class="form-label">Порядок сортировки</label>
        <input name="sortOrder" type="text" class="form-control" id="sortOrder" placeholder="Порядок сортировки" value="{{$category->sort_order}}">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>



@endsection
