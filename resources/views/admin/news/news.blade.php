@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-2">
    <h1>Список новостей</h1>
</div>
<a class="btn mb-3 btn-primary" href="{{ route('admin.news.add') }}">Добавить</a>

@foreach($data as $news)
  <div class="admin_gal_el mb-4">
    <div class="admin_gal_el__img-box mb-2 me-2">
        <img class="admin_gal_el__img" src="{{ $news->image_src }}" alt="">
    </div>
    <div class="d-flex flex-column">
      <div class="">ID: {{ $news->id }}</div>
      <div class="">Дата публикации: {{ $news->created_at }}</div>
      @if($news->is_social == 1)
      <div class="mt-1 fw-bold">Афиша</div>
      @endif
      <div class="admin_gal_el__h1">{{ $news->name }}</div>
      <div class="d-flex">
         <a class="fw-bold btn btn-primary me-2" href="{{route('admin.news.update', $news->id )}}">Редактировать</a>
         <form method="post" action="{{route('admin.news.delete', ['news' => $news])}}">
          @csrf
          @method('delete')
         <input type="submit" value="Удалить" class="fw-bold btn btn-danger me-2"/>
         </form>
      </div>
    </div>
  </div>
  
@endforeach



@endsection
