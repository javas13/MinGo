@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<script type="module">
    tinymce.init({
        selector: '#content',
        advcode_inline: true,
        setup: function (editor) {
        editor.on('init', function (e) {
            editor.setContent('{!! $news->text !!}');
        });
        },
        images_upload_url: '/admin/upload-image-tmc',
        images_upload_base_path: '',
        relative_urls: false,
        remove_script_host: false,
        plugins: [
            'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export', 'codesample',
            'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
            'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],

        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'

    });
</script>
    <script type="module">
        function example_image_upload_handler(blobInfo, success, failure, progress) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/admin/upload-image-tmc');

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function () {
                var json;

                if (xhr.status === 403) {
                    failure('HTTP Error: ' + xhr.status, { remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            xhr.onerror = function () {
                failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        };

    </script>

<div class="d-flex align-items-center">
    <h1>Редактировать новость</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.news.update.store', $news->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="image_src" value="{{$news->image_src}}" class="image-src-js">
    <div class="mb-3">
        <label for="name" class="form-label">Название новости</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"  placeholder="Название" value="{{ $news->name }}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="seoName" class="form-label">Seo name</label>
        <input name="seoName" type="text" class="form-control" id="seoName" placeholder="Seo name" value="{{ $news->seo_name }}">
    </div>
    <div class="mb-3">
        <label for="seoDescript" class="form-label">Seo description</label>
        <input name="seoDescript" type="text" class="form-control" id="seoDescript" placeholder="Seo description" value="{{ $news->seo_description }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="content" class="form-label">Текст новости</label>
        <textarea id="content"></textarea>
    </div>
    <div class="mt-3 d-flex align-items-center">
        <input name="issocial" @if($news->is_social == 1) checked @endif value='{{ $news->is_social }}' class="form-check-input me-2 check-medium is-social-js" type="checkbox" id="issocial">
        <label class="form-check-label">Это новость является соц сетью и афишой?</label>
    </div>
    @if($news->is_social == 1)
    <div class="social-options news-add-social-visible social-options-js">
        <div class="mt-3">
            <select name="isexternallink" class="form-select" aria-label="Default select example">
                @if($news->is_link_external	== 1)
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
            <input name="link" type="text" class="form-control" id="link" placeholder="Ссылка" value="{{ $news->link }}">
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
    <div class="admin_img_update-box mt-2">
        <img class="admin_img_update" src="{{$news->image_src}}" alt="">
    </div>
    <div>Размер картинки должен быть 700x700</div>
    <div class="input-group bg-secondary text-white mb-3" id="download_input_group">
        <label class="input-group-text bg-secondary text-white" for="js-file">Изображение</label>
        <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control bg-secondary text-white" id="js-file">
    </div>
    <div class="mb-3 mt-3">
        <button class="btn btn-primary">Обновить</button>
    </div>
</form>

<script type="module">
    $('#article_form').on('submit', function () {
        $('#article_form').append('<input type="text" value="" class="rawTmc_id" name="content" />');
        let tmcraw = document.querySelector('.rawTmc_id');
        tmcraw.value = tinymce.activeEditor.getContent({ format: 'raw' });
        return true;
    });
</script>

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