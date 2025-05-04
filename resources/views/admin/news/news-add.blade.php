@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

    <script type="module">
        tinymce.init({
            selector: '#content',
            advcode_inline: true,
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
    <h1>Добавить новость</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.news.add.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Название новости</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{old('name')}}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="seoName" class="form-label">Seo name</label>
        <input name="seoName" type="text" class="form-control" id="seoName" placeholder="Seo name" value="">
    </div>
    <div class="mb-3">
        <label for="seoDescript" class="form-label">Seo description</label>
        <input name="seoDescript" type="text" class="form-control" id="seoDescript" placeholder="Seo description" value="">
    </div>
    <div class="mb-3">
        <label class="form-label" for="content" class="form-label">Текст новости</label>
        <textarea id="content"></textarea>
    </div>
    <div>Размер картинки должен быть 700x700</div>
    <div class="input-group bg-secondary text-white mb-3" id="download_input_group">
        <label class="input-group-text bg-secondary text-white" for="inputGroupFile01">Изображение</label>
        <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control bg-secondary text-white" id="inputGroupFile01">
    </div>
    <div class="mt-3 d-flex align-items-center">
        <input name="issocial"  value="0" class="form-check-input me-2 check-medium is-social-js" type="checkbox" id="issocial">
        <label class="form-check-label">Это новость является соц сетью и афишой?</label>
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

<script type="module">
    $('#article_form').on('submit', function () {
        $('#article_form').append('<input type="text" value="" class="rawTmc_id" name="content" />');
        let tmcraw = document.querySelector('.rawTmc_id');
        tmcraw.value = tinymce.activeEditor.getContent({ format: 'raw' });
        return true;
    });
</script>


@endsection