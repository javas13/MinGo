@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<div class="d-flex align-items-center">
    <h1>Добавить баннер</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.banners.add.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Текст баннера</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Текст баннера" value="{{old('name')}}">
    </div>
    <div class="mb-3">
        <label for="btn_name" class="form-label">Текст кнопки</label>
        <input name="btn_name" type="text" class="form-control @error('name') is-invalid @enderror" id="btn_name" placeholder="Текст кнопки" value="{{old('name')}}">
    </div>
    <div class="mb-3">
        <label for="sort_order" class="form-label">Порядок сортировки</label>
        <input name="sort_order" type="text" class="form-control @error('name') is-invalid @enderror" id="sort_order" placeholder="Порядок сортировки" value="{{old('name')}}">
    </div>
    <div>Размер картинки должен быть 1920x1080</div>
    <div class="input-group bg-secondary text-white mb-3" id="download_input_group">
        <label class="input-group-text bg-secondary text-white" for="inputGroupFile01">Изображение</label>
        <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control bg-secondary text-white" id="inputGroupFile01">
    </div>
    <div class="mt-3 d-flex align-items-center">
        <input name="is_link_open" value="0" class="form-check-input me-2 check-medium is-social-js" type="checkbox" id="is_link_open">
        <label class="form-check-label">Этот банер открывает ссылку? (если галочка не стоит, то при клике на баннер, будет открываться форма заявки)</label>
    </div>
    <div class="social-options social-options-js">
        <div class="mt-3">
            <select name="isexternallink" class="form-select" aria-label="Default select example">
                <option value="0" selected>Внутренняя ссылка (ссылка внутри сайта)</option>
                <option value="1">Внешняя ссылка (ссылка не вшений ресурс)</option>
            </select>
        </div>
        <div class="mt-3">
            <label for="link" class="form-label">Ссылка</label>
            <input name="link" type="text" class="form-control" id="link" placeholder="Ссылка" value="">
        </div>
    </div>
    <div class="mb-3 mt-3">
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>



@endsection