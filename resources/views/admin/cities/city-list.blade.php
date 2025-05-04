@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-5">
    <h1>Список городов</h1>
</div>

@foreach($cities as $city)
  <div class="admin_gal_el mb-4">
    <div class="d-flex flex-column">
      <div class="admin_gal_el__h1">ID: {{ $city->id }}</div>
      <div class="admin_gal_el__h1">{{ $city->name }}</div>
      <div class="d-flex">
         <a class="fw-bold btn btn-primary me-2" href="{{route('admin.cities.update', $city->id )}}">Редактировать</a>
         <form method="post" action="{{route('admin.cities.delete', ['city' => $city])}}">
          @csrf
          @method('delete')
         <input type="submit" value="Удалить" class="fw-bold btn btn-danger me-2"/>
         </form>
      </div>
    </div>
  </div>
  
@endforeach



@endsection
