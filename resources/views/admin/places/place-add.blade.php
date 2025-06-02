@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=5f0a3b1e-fbda-49de-8aaf-b1e7e50de135&lang=ru_RU" type="text/javascript"></script>

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
    <h1>Добавить заведение</h1>
</div>

<form id="article_form" class="mt-4" action="{{route ('admin.places.add.store')}}" method="post" enctype="multipart/form-data">
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
        <label for="name" class="form-label">Название заведения*</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Название" value="{{old('name')}}">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Категория*</label>
        <select id="category" name="category_id" class="form-select" aria-label="Default select example">
            @foreach($categories as $category)
            @if ($loop->first)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}selected>{{ $category->name }}</option>
            @else
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="average_bill" class="form-label">Средний чек</label>
        <input name="average_bill" type="number" class="form-control" id="average_bill" placeholder="Средний чек" value="{{old('average_bill')}}">
    </div>
    <div class="mb-3">
        <label for="phone_formatted" class="form-label">Номер телефона</label>
        <input name="phone_formatted" class="form-control phone-mask-js" id="phone_formatted" value="{{old('phone_formatted')}}">
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">Город*</label>
        <select id="city" name="city_id" class="form-select" aria-label="Default select example">
            @foreach($cities as $city)
            @if ($loop->first)
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}selected>{{ $city->name }}</option>
            @else
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="district" class="form-label">Район*</label>
        <select id="district" name="district_id" class="form-select" aria-label="Default select example">
            @foreach($districts as $district)
            @if ($loop->first)
                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}selected>{{ $district->name }}</option>
            @else
                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3  @error('description') border border-danger @enderror">
        <label class="form-label @error('description') text-danger fw-bold @enderror" for="content">Описание*</label>
        <textarea class="" name="description" id="content">{{old('description')}}</textarea>
    </div>
    <div class="mb-3 d-flex flex-column">
        <label class="form-label">Данные для картинга</label>
        <div class="d-flex flex-row">
            <input name="check_in_price_from" type="number" class="form-control" placeholder="Цена заезда от" value="{{old('check_in_price_from')}}">
            <input name="check_in_price_to" type="number" class="form-control" placeholder="Цена заезда до" value="{{old('check_in_price_to')}}">
        </div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Кухни</label>
        <select id="kitchens" name="kitchens[]" multiple>
            @foreach($kitchens as $kitchen)
            <option {{ in_array($kitchen->id, old('kitchens', [])) ? 'selected' : '' }} value="{{ $kitchen->id }}">{{ $kitchen->name }}</option>
            @endforeach
        </select>
    </div>
    <label class="form-label">График работы</label>
    <div class="mt-1 mb-3 d-flex align-items-center">
        <input id="is_schedule_active" name="is_schedule_active" value="{{ old('is_schedule_active') ? '1' : '0' }}" {{ old('is_schedule_active') ? 'checked' : '' }} class="show-schedule-form-js form-check-input me-2 check-medium" type="checkbox">
        <label for="is_schedule_active" class="form-check-label">Указывать график работы?</label>
    </div>
    <div id="schedule-list" class="schedule-wrapper {{ old('is_schedule_active') ? 'active' : '0' }}">
        @foreach($days as $dayNumber => $dayName)
        <div class="day-row">
            <div class="day-name">{{ $dayName }}</div>
            <input name="schedules[{{ $dayNumber }}][day_name]" value="{{ $dayName }}" type="hidden">
            <div class="time-fields">
                <input type="time" 
                       name="schedules[{{ $dayNumber }}][open_time]"
                       value="{{ old('schedules.'.$dayNumber.'.open_time', $schedule[$dayNumber]->open_time ?? '') }}"
                       {{ old('schedules.'.$dayNumber.'.is_closed') ? 'disabled' : '' }}
                       {{ $schedule[$dayNumber]->is_closed ?? false ? 'disabled' : '' }}>
                
                <span>-</span>
                
                <input  type="time" 
                       name="schedules[{{ $dayNumber }}][close_time]"
                       value="{{ old('schedules.'.$dayNumber.'.close_time', $schedule[$dayNumber]->close_time ?? '') }}"
                       {{ old('schedules.'.$dayNumber.'.is_closed') ? 'disabled' : '' }}
                       {{ $schedule[$dayNumber]->is_closed ?? false ? 'disabled' : '' }}>
            </div>

            <div class="closed-checkbox">
                <input type="hidden" name="schedules[{{ $dayNumber }}][is_closed]" value="0">
                <label class="d-flex justify-content-center align-items-center gap-1">
                    <input class="closed-chkbox closed-schedule-chkbox-js" type="checkbox" 
                           name="schedules[{{ $dayNumber }}][is_closed]" 
                           value="{{ old('schedules.'.$dayNumber.'.is_closed') ? '1' : '0' }}"
                           {{ old('schedules.'.$dayNumber.'.is_closed') ? 'checked' : '' }}>
                    Закрыто
                </label>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Адрес* (Введите адрес и нажмите кнопку найти для указания точки на карте или укажите точку вручную) (Для точного поиска вы можете указать адрес с городом и регионом но после установки нужной метки в этом поле должен остаться адрес без города и региона!)</label>
        <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Адрес" value="{{old('address')}}">
    </div>
    <button type="button" id="search-address" class="btn btn-primary">
            Найти
    </button>

    <div id="map" style="width: 100%; height: 400px"></div>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
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
                            type="radio"
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
    <div class="mt-3">
        <div class="form-label fw-bold">SEO-Данные</div>
        <p>Seo-name<b> автоматически сформируется</b> при создании заведения<br/>
        <b>Seo-description необходимо прописать вручную</b> Можете скопировать часть описания заведения и вставить его в seo-description
        <b>Желательная длина Seo-description от 90 до 160 символов</b>
    </p>
    </div>
    <div class="mb-3">
        <label for="seoName" class="form-label">Seo name (Название сайта в поиске, генерируется автоматически) (Пример: Бар Марусовка на улице Щапова в Казани)</label>
        <input name="seo_name" type="text" class="form-control @error('seo_name') is-invalid @enderror" id="seoName" placeholder="Seo name" value="">
    </div>
    <div class="mb-3">
        <label for="seoDescript" class="form-label">Seo description* (Описание сайта в поиске, от 90 до 200 символов) (Пример - "Бар Марусовка на улице Щапова. В меню вегетарианское меню, европейская кухня, коктейльная карта, паназиатская кухня, паста, русская кухня, торты на заказ. Средний чек - 1200 рублей.")</label>
        <input name="seo_description" maxlength="300" type="text" class="form-control max-length-count-input-js @error('seo_description') is-invalid @enderror" id="seoDescript" placeholder="Seo description" value="{{ old('seo_description') }}">
        <div class="char-counter-js"><span id="current-count">0</span>/<span class="max-length-js">100</span></div>
    </div>

    <div class="mt-3 mb-3 d-flex align-items-center">
        <input id="is_active_btn" checked name="is_active" value="0" class="form-check-input me-2 check-medium" type="checkbox">
        <label class="form-check-label">Активно? (Если галочка не стоит, то заведение не будет показываться)</label>
    </div>
    <div class="form-group">
        <label for="image">Главное Изображение</label>
        <input type="file" class="form-control" id="image_input" name="image">
        <label for="image_alt" class="" >Название изображения* (Опишите что находится на изображении, пример - Летняя терраса ресторана марусовка, alt атрибут)</label>
        <input name="image_alt" type="text" class="form-control @error('image_alt') is-invalid @enderror" id="image_alt" placeholder="Название главной картинки" value="{{ old('image_alt') }}">
        
        <!-- Превью изображения -->
        <img id="preview_image" 
             style="max-width: 300px; margin-top: 10px; display: block;">
    </div>

    <div class="form-group">
        <label>Остальные Изображения</label>
        
        <!-- Контейнер для превью -->
        <div id="sortable-container" class="row mb-1">
            @foreach(old('images', $place->images ?? []) as $image)
                <div class="image-item col-md-3 mb-3" data-id="{{ $image->id ?? '' }}">
                    <img src="{{ isset($image->image_path) ? asset('storage/'.$image->image_path) : $image['preview'] }}" 
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
        <button class="btn btn-primary">Добавить</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/7.6.1/imask.min.js"></script>

<script>
    IMask(
        document.querySelector('.phone-mask-js'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>

<script type="module">
$(document).ready(function() {
    $('#city').change(function() {
        const cityId = $(this).val();
        const $districtSelect = $('#district');
        
        // Очищаем и добавляем дефолтный option
        // $districtSelect.empty().append('<option value="">Выберите район</option>');
        $districtSelect.empty();
        
        if (!cityId) return;
        
        // Показываем загрузку
        $districtSelect.prop('disabled', true);


        $.ajax({
              headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'GET',
              url: `/admin/districts/city/${cityId}`,
              processData: false,
              contentType: false  
          }).done(function (districts) {
              districts.forEach(district => {
                $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
            });
            $districtSelect.prop('disabled', false);
          }).fail(function () {
              Swal.fire(
                  'Ошибка!',
                  'Неизвестная ошибка',
                  'error'
              )
          });
    });
});
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

<script>
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
    </script>

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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        ymaps.ready(initMap);
    });

    function initMap() {
        const map = new ymaps.Map('map', {
            center: [55.76, 37.64], // Москва по умолчанию
            zoom: 10
        });

        const placemark = new ymaps.Placemark(map.getCenter(), {}, {
            draggable: true,
            preset: 'islands#redDotIcon'
        });

        map.geoObjects.add(placemark);

        // Функция обновления координат
        function updateCoordinates(coords) {
            placemark.geometry.setCoordinates(coords);
            map.setCenter(coords, 15);
            document.getElementById('latitude').value = coords[0];
            document.getElementById('longitude').value = coords[1];
        }

        // Обработка перемещения метки
        placemark.events.add('dragend', function(e) {
            const coords = placemark.geometry.getCoordinates();
            updateCoordinates(coords);
            // Дополнительно можно получить адрес по координатам
            getAddressByCoords(coords);
        });

        // Обработка клика по карте
        map.events.add('click', function(e) {
            const coords = e.get('coords');
            updateCoordinates(coords);
            getAddressByCoords(coords);
        });

        // Поиск адреса
        document.getElementById('search-address').addEventListener('click', function() {
            const address = document.getElementById('address').value;
            
            ymaps.geocode(address, {
                results: 1
            }).then(function(res) {
                const firstGeoObject = res.geoObjects.get(0);
                if (firstGeoObject) {
                    const coords = firstGeoObject.geometry.getCoordinates();
                    updateCoordinates(coords);
                    
                    // Обновляем поле адреса точным значением от Яндекса
                    document.getElementById('address').value = firstGeoObject.getAddressLine();
                } else {
                    alert('Адрес не найден');
                }
            }).catch(function(error) {
                alert('Ошибка при поиске адреса: ' + error);
            });
        });

        // Функция получения адреса по координатам (опционально)
        function getAddressByCoords(coords) {
            ymaps.geocode(coords).then(function(res) {
                const firstGeoObject = res.geoObjects.get(0);
                if (firstGeoObject) {
                    document.getElementById('address').value = firstGeoObject.getAddressLine();
                }
            });
        }

        // Если есть сохраненные координаты
        @if(isset($place) && $place->latitude && $place->longitude)
            const savedCoords = [{{ $place->latitude }}, {{ $place->longitude }}];
            updateCoordinates(savedCoords);
            getAddressByCoords(savedCoords);
            
            // Если есть сохраненный адрес
            @if(isset($place->address))
                document.getElementById('address').value = '{{ $place->address }}';
            @endif
        @endif
    }
</script>


@endsection