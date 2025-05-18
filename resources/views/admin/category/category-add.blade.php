@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center">
    <h1>Добавить категорию</h1>
</div>

<form id="categoryAddForm" class="mt-4" action="{{ route('admin.category.add.store')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Название категории*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{old('name')}}">
    </div>
    <div class="mb-3">
        <label for="name_single" class="form-label">Название категории (В единственном числе)*</label>
        <input name="name_single" type="text" class="form-control @error('name_single') is-invalid @enderror" id="name_single" placeholder="Название" value="{{old('name_single')}}">
    </div>
    <div class="mb-3">
        <label for="sortOrder" class="form-label">Порядок сортировки</label>
        <input name="sortOrder" type="text" class="form-control" id="sortOrder" placeholder="Порядок сортировки">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>



@endsection
