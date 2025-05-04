@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>

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
    <h1>Редактирование заведения</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.places.update.store', $place->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Название заведения</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{ old('name', $place->name) }}">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Адрес</label>
        <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Адрес" value="{{ old('address', $place->address) }}">
    </div>
    <div class="mb-3">
        <label for="average_bill" class="form-label">Средний чек</label>
        <input name="average_bill" type="number" class="form-control" id="average_bill" placeholder="Средний чек" value="{{ old('average_bill', $place->average_bill) }}">
    </div>
    <div class="mb-3 @error('description') border border-danger @enderror">
        <label class="form-label @error('description') text-danger fw-bold @enderror" for="content" class="form-label">Описание</label>
        <textarea name="description" id="content">{{ old('description', $place->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Категория</label>
        <select id="category" name="category_id" class="form-select" aria-label="Default select example">
            @foreach($categories as $category)
            @if (old('category_id', $place->category_id) == $category->id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Кухни</label>
        <select id="kitchens" name="kitchens[]" multiple>
            @foreach($kitchens as $kitchen)
                <option value="{{ $kitchen['id'] }}"  {{ in_array($kitchen['id'], old('kitchens', $selectedKitchens, [])) ? 'selected' : '' }} >{{ $kitchen['name'] }}</option>
            @endforeach
        </select>
    </div>
    <label class="form-label">График работы</label>
    <div class="mt-1 mb-3 d-flex align-items-center">
        <input @if(old('is_schedule_active', $place->is_schedule_active) == 1) checked @endif id="is_schedule_active" name="is_schedule_active" value="@if(old('is_schedule_active', $place->is_schedule_active) == 1) 1 @else 0 @endif" class="show-schedule-form-js form-check-input me-2 check-medium" type="checkbox">
        <label for="is_schedule_active" class="form-check-label">Указывать график работы?</label>
    </div>
    <div id="schedule-list" class="schedule-wrapper @if(old('is_schedule_active', $place->is_schedule_active) == 1) active @endif">
        @foreach($days as $dayNumber => $dayName)
        <div class="day-row">
            <div class="day-name">{{ $dayName }}</div>
            <input name="schedules[{{ $dayNumber }}][day_name]" value="{{ $dayName }}" type="hidden">
            <div class="time-fields">
                <input type="time" 
                       name="schedules[{{ $dayNumber }}][open_time]"
                       value="{{ old('schedules.'.$dayNumber.'.open_time', $place->schedules[$dayNumber]->open_time_formatted ?? '') }}"
                       {{ $place->schedules[$dayNumber]->is_closed ?? false ? 'disabled' : '' }}>
                       
                <span>-</span>
                
                <input  type="time" 
                       name="schedules[{{ $dayNumber }}][close_time]"
                       value="{{ old('schedules.'.$dayNumber.'.close_time', $place->schedules[$dayNumber]->close_time_formatted ?? '') }}"
                       {{ $place->schedules[$dayNumber]->is_closed ?? false ? 'disabled' : '' }}
                       >
            </div>

            <div class="closed-checkbox">
                <input type="hidden" name="schedules[{{ $dayNumber }}][is_closed]" value="0">
                <label class="d-flex justify-content-center align-items-center gap-1">
                    <input class="closed-chkbox closed-schedule-chkbox-js" type="checkbox" 
                           name="schedules[{{ $dayNumber }}][is_closed]" 
                           value="@if(old('schedules.'.$dayNumber.'.is_closed', $place->schedules[$dayNumber]->is_closed ?? false)) 1 @endif"
                           {{-- @if($place->schedules[$dayNumber]->is_closed == 1) 1 @else 0 @endif --}}
                           @if(old('schedules.'.$dayNumber.'.is_closed', $place->schedules[$dayNumber]->is_closed ?? false)) checked @endif>
                           {{-- {{ $place->schedules[$dayNumber]->is_closed ?? false ? 'checked' : '' }}> --}}
                    Закрыто
                </label>
            </div>
        </div>
        @endforeach
    </div>

    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              Данные для фильтров опроса
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <label class="form-label">Настроение</label>
                @foreach (App\Models\Place::MOOD_ANSWERS as $key => $label)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="mood[]"
                            value="{{ $key }}"
                            id="mood_{{ $key }}"
                            class="form-check-input"
                            {{ in_array($key, old('mood', $place->mood ?? [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="mood_{{ $key }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
                <label class="form-label">С кем пойдёшь?</label>
                @foreach (App\Models\Place::COMPANY_ANSWERS as $key => $label)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="company[]"
                            value="{{ $key }}"
                            id="company_{{ $key }}"
                            class="form-check-input"
                            {{ in_array($key, old('company', $place->company ?? [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="company_{{ $key }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
                <label class="form-label">Что хочешь сделать?</label>
                @foreach (App\Models\Place::ACTIVITY_ANSWERS as $key => $label)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="activity[]"
                            value="{{ $key }}"
                            id="activity_{{ $key }}"
                            class="form-check-input"
                            {{ in_array($key, old('activity', $place->activity ?? [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="activity_{{ $key }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
                <label class="form-label">Какой бюджет?</label>
                @foreach (App\Models\Place::BUDGET_ANSWERS as $key => $label)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="budget[]"
                            value="{{ $key }}"
                            id="budget_{{ $key }}"
                            class="form-check-input"
                            {{ in_array($key, old('budget', $place->budget ?? [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="budget_{{ $key }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
                <label class="form-label">Какая атмосфера?</label>
                @foreach (App\Models\Place::ATMOSPHERE_ANSWERS as $key => $label)
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="atmosphere[]"
                            value="{{ $key }}"
                            id="atmosphere_{{ $key }}"
                            class="form-check-input"
                            {{ in_array($key, old('atmosphere', $place->atmosphere ?? [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="atmosphere_{{ $key }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>

    <div class="mt-3 mb-3 d-flex align-items-center">
        <input id="is_active_btn" name="is_active" value="@if(old('is_active', $place->is_active) == 1) 1 @else 0 @endif" @if(old('is_active', $place->is_active) == 1) checked @endif class="form-check-input me-2 check-medium" type="checkbox">
        <label class="form-check-label">Активно? (Если галочка не стоит, то заведение не будет показываться)</label>
    </div>
    <div class="form-group">
        <label for="image">Главное Изображение</label>
        <input type="file" class="form-control" id="image_input" name="image">
        
        <!-- Превью изображения -->
        <img class="mb-2" src="/{{ $place->image_src }}" id="preview_image" 
             style="max-width: 300px; margin-top: 10px; display: block;">
    </div>

    <div class="form-group">
        <label>Остальные Изображения</label>
        
        <!-- Контейнер для превью -->
        <div id="sortable-container" class="row mb-1">
            @foreach($place->images as $image)
                <div class="image-item col-md-3 mb-3" data-id="{{ $image->id ?? '' }}">
                    <img src="/{{ $image->image_src }}" 
                         class="img-thumbnail">
                    <input type="hidden" name="images[]" value="{{ $image->id ?? '' }}">
                    <button type="button" class="btn btn-danger btn-sm remove-image">×</button>
                </div>
            @endforeach
        </div>

        <!-- Кнопка загрузки -->
        <div class="custom-file">
            <input type="file" 
                   class="form-control mb-4" 
                   id="image_upload" 
                   name="uploaded_images[]" 
                   multiple
                   accept="image/*">
            {{-- <label class="custom-file-label" for="image_upload">Выберите файлы</label> --}}
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Сохранить</button>
    </div>
</form>


<script>
    
</script>


<script>
    document.querySelectorAll('.closed-schedule-chkbox-js').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const timeInputs = this.closest('.day-row').querySelectorAll('input[type="time"]');
            timeInputs.forEach(input => input.disabled = this.checked);
        });
    });
</script>

<script>
    document.getElementById('image_input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview_image');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>

{{-- <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        if($('.show-schedule-form-js').is(':checked')){
            let isValid = true;
        
        document.querySelectorAll('.day-row').forEach(row => {
            const isClosed = row.querySelector('input[type="checkbox"]').checked;
            const openTime = row.querySelector('input[name$="[open_time]"]');
            const closeTime = row.querySelector('input[name$="[close_time]"]');
    
            if (!isClosed) {
                if (!openTime.value || !closeTime.value) {
                    isValid = false;
                    row.classList.add('has-error');
                    alert(`Заполните время для дня: ${row.querySelector('.day-name').textContent}`);
                }
            }
        });
    
        if (!isValid) {
            e.preventDefault();
            window.scrollTo(0, 0);
        }
        }
    });
    </script> --}}

    <script type="module">
        $('.closed-schedule-chkbox-js').click(function() {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
                
                // Для демонстрации - выводим текущее значение в консоль
                console.log('Текущее значение:', $(this).val());
            });

            $('.show-schedule-form-js').change(function() {
                if ($(this).is(':checked')) {
                    $('#schedule-list').show();
                    $(this).val('1');
                } else {
                    $('#schedule-list').hide();
                    $(this).val('0');
                }
            });
    </script>

<script type="module">
    new MultiSelectTag('kitchens');
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Инициализация Sortable
    const sortable = new Sortable(document.getElementById('sortable-container'), {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onUpdate: updateImageOrder
    });

    // Обработка загрузки файлов
    document.getElementById('image_upload').addEventListener('change', function(e) {
        console.log('2313');
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const container = document.getElementById('sortable-container');
                const div = document.createElement('div');
                div.className = 'image-item col-md-3 mb-3';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail">
                    <button type="button" class="btn btn-danger btn-sm remove-image">×</button>
                    <input type="hidden" name="uploaded_images_preview[]" value="${e.target.result}">
                `;
                container.appendChild(div);
                initRemoveButton(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Удаление изображений
    function initRemoveButton(element) {
        element.querySelector('.remove-image').addEventListener('click', function() {
            element.remove();
        });
    }

    // Инициализация существующих кнопок удаления
    document.querySelectorAll('.remove-image').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.image-item').remove();
        });
    });

    // Обновление порядка изображений
    function updateImageOrder() {
        const container = document.getElementById('sortable-container');
        Array.from(container.children).forEach((item, index) => {
            const hiddenInput = item.querySelector('input[name="images[]"]');
            if (hiddenInput) {
                hiddenInput.name = `images[${index}]`;
            }
        });
    }
</script>

@endsection