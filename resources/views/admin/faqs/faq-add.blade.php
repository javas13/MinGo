@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Добавить Часто-Задаваемый-Вопрос</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.faqs.add.store')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="question_name" class="form-label">Название вопроса</label>
        <input name="question_name" type="text" class="form-control" id="question_name" placeholder="Название вопроса" value="">
    </div>
    <div class="mb-3">
        <label for="answer_name" class="form-label">Ответ</label>
        <input name="answer_name" type="text" class="form-control" id="answer_name" placeholder="Ответ" value="">
    </div>
    <div class="mb-3">
        <label for="sortOrder" class="form-label">Порядок сортировки</label>
        <input name="sortOrder" type="text" class="form-control" id="sortOrder" placeholder="Порядок сортировки" value="">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>



@endsection