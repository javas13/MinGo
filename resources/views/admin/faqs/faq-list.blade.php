@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-2">
    <h1>Список Часто-Задаваемых-Вопросов</h1>
</div>
<a class="btn mb-3 btn-primary" href="{{ route('admin.faqs.add') }}">Добавить</a>

@foreach($faqs as $faq)
  <div class="admin_gal_el mb-4">
    <div class="d-flex flex-column">
      <div class="admin_gal_el__h1">ID: {{ $faq->id }}</div>
      <div class="admin_gal_el__h1">{{ $faq->question_name }}</div>
      <div class="d-flex">
         <a class="fw-bold btn btn-primary me-2" href="{{route('admin.faqs.update', $faq->id )}}">Редактировать</a>
         <form method="post" action="{{route('admin.faqs.delete', ['faq' => $faq])}}">
          @csrf
          @method('delete')
         <input type="submit" value="Удалить" class="fw-bold btn btn-danger me-2"/>
         </form>
      </div>
    </div>
  </div>
  
@endforeach



@endsection
