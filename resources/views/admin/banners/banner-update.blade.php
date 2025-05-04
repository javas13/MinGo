@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')


<div class="d-flex align-items-center">
    <h1>Редактировать банер</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.banners.update.store', $banner->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="image_src" value="{{$banner->image_src}}" class="image-src-js">
    <div class="mb-3">
        <label for="name" class="form-label">Текст баннера</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Текст баннера" value="{{ $banner->name }}">
    </div>
    <div class="mb-3">
        <label for="btn_name" class="form-label">Текст кнопки</label>
        <input name="btn_name" type="text" class="form-control" id="btn_name" placeholder="Текст кнопки" value="{{ $banner->btn_name }}">
    </div>
    <div class="mb-3">
        <label for="sort_order" class="form-label">Порядок сортировки</label>
        <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Порядок сортировки" value="{{ $banner->sort_order }}">
    </div>
    <div class="admin_img_update-box">
        <img class="admin_img_update" src="{{$banner->image_src}}" alt="">
    </div>
    <div>Размер картинки должен быть 1920x1080</div>
    <div class="input-group bg-secondary text-white mb-3" id="download_input_group">
        <label class="input-group-text bg-secondary text-white" for="inputGroupFile01">Изображение</label>
        <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control bg-secondary text-white" id="js-file">
    </div>
    <div class="mt-3 d-flex align-items-center">
        <input name="is_link_open" @if($banner->is_link_open == 1) checked @endif value='{{ $banner->is_link_open }}' class="form-check-input me-2 check-medium is-social-js" type="checkbox" id="is_link_open">
        <label class="form-check-label">Этот банер открывает ссылку? (если галочка не стоит, то при клике на баннер, будет открываться форма заявки)</label>
    </div>
    @if($banner->is_link_open == 1)
    <div class="social-options news-add-social-visible social-options-js">
        <div class="mt-3">
            <select name="isexternallink" class="form-select" aria-label="Default select example">
                @if($banner->is_link_external == 1)
                <option value="0">Внутренняя ссылка (ссылка внутри сайта)</option>
                <option value="1" selected>Внешняя ссылка (ссылка не вшений ресурс)</option>
                @else
                <option value="0" selected>Внутренняя ссылка (ссылка внутри сайта)</option>
                <option value="1">Внешняя ссылка (ссылка не вшений ресурс)</option>
                @endif
            </select>
        </div>
        <div class="mt-3">
            <label for="link" class="form-label">Ссылка</label>
            <input name="link" type="text" class="form-control" id="link" placeholder="Ссылка" value="{{ $banner->link }}">
        </div>
    </div>
    @else
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
    @endif
    <div class="mb-3 mt-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>


<script type="module">
    //let csrf = querySelector('meta[name="csrf-token"]').getAttribute('content');
    $("#js-file").change(function(){
        if (window.FormData === undefined) {
            alert('В вашем браузере загрузка файлов не поддерживается');
        } else {
            var formData = new FormData();
            $.each($("#js-file")[0].files, function(key, input){
                formData.append('image', input);
            });

            formData.append("folderName", "portfolio");
     
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/admin/image-load',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(msg){
                    let srcForShow = msg.data;
                    $(".admin_img_update").attr('src', srcForShow); 
                    $(".image-src-js").val(msg.data);
                    console.log('2');
                }
            });
        }
    });
     
    /* Удаление загруженной картинки */
    function remove_img(target){
        $(target).parent().remove();
    }
    </script>


@endsection