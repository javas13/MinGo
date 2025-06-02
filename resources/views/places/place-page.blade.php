@extends('layouts.main')

@section('title', $place->seo_name. ': адрес, фото, цены - MinGo')
@section('description', $place->seo_description)	
@section('canonical', 'https://mingonow.ru/places/'.$place->slug)
@section('ogTitle', $place->seo_name. ': адрес, фото, цены - MinGo')
@section('ogDescription', $place->seo_description)	
@section('ogImage', $place->thumb_image_src)	

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script type="module" src="https://cdn.jsdelivr.net/npm/jquery-expander@1.7.0/jquery.expander.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<script src="https://api-maps.yandex.ru/2.1/?apikey=5f0a3b1e-fbda-49de-8aaf-b1e7e50de135&lang=ru_RU" type="text/javascript"></script>


<div class="place-page">
    <div class="container places-container">
        <div class="breads">
			<ul class="breads__breads-list">
				@foreach($breads as $bread)
				  @if ($loop->last)
					<li class="navigation_elem">
					   <span>{{ $bread['title'] }}</span>
					</li>
				  @else
					<li class="breads__breads-elem">
					   <a href="{{ $bread['link'] }}">{{ $bread['title'] }}</a>
					</li>
				  @endif
				@endforeach			
		  </ul>
		</div>
        <div class="place-page__top-info">
            <div class="place-page__top-info-left">
                {{-- <div class="place-page__top-cover"></div> --}}
                <div class="place-page__top-cover-wrapper">
                    <div class="place-page__top-cover">
                        <img style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;" src="@if($place->image_src == null) /img/admin/no-image.png @else {{ $place->image_src }} @endif" alt="">
                    </div>
                </div>
                <div class="place-page__phone-row">
                    <i class="fas fa-phone fa-flip-horizontal place-page__phone-icon"></i>
                    <a href="tel:{{ $place->phone_numeric }}" class="place-page__phone-number">{{ $place->phone_formatted }}</a>
                </div>
                <div class="place-page__short-info">
                    <h1 class="place-page__title">{{ $place->name }}</h1>
                    <div class="@if($place->category->name == 'Картинги') place-card__category-col @else place-page__category-row @endif">
                        <div class="place-page__category">{{ $place->category->name_single }}</div>
                        @if($place->category->name == 'Картинги')
                        <div class="place-page__carting-price">Цена заезда: от {{ $place->check_in_price_from }}₽ до {{ $place->check_in_price_to }}₽</div>
                        @elseif($place->average_bill != null)
                        <div class="place-page__categ-separator">-</div>
                        <div class="place-page__average-bill-row" data-bs-trigger="hover" data-bs-toggle="popover" title="График работы" data-bs-placement="top" data-bs-template='<div class="popover average-bill-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-body d-flex flex-column"></div></div>' data-bs-html="true" data-bs-content="@include('partials.average-bill-popup')">
                            @foreach(App\Models\Place::getAvailableRanges() as $rangeNumber => $range)
                            <span class="place-page__average-bill-ruble @if(App\Models\Place::getAverageCheckRange($place->average_bill)['range_number'] >=  $rangeNumber) active @endif">₽</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="place-page__atmosphere">
                        @if($place->atmosphere_text == 'Тихое место')
                        <i class="fas fa-volume-mute"></i> {{ $place->atmosphere_text; }}
                        @else
                        <i class="fas fa-volume-up"></i> {{ $place->atmosphere_text; }}
                        @endif
                    </div>
                    <div class="place-page__address">{{ $place->address }}</div>
                    @if($place->is_schedule_active == true)
                    <div class="position-relative place-page__shedule-wrap">
                        <div class="place-page__shedule" data-bs-toggle="popover" title="График работы" data-bs-placement="bottom" data-bs-template='<div class="popover schedule-popover fade-slide" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header schedule-popover-header"></h3><div class="popover-body d-flex flex-column"></div></div>' data-bs-html="true" data-bs-content="@include('partials.schedule')">@if($place->todayWorkingHours->is_closed == true) Закрыто @else Открыто c {{ $place->todayWorkingHours->open_time_formatted }} до {{ $place->todayWorkingHours->close_time_formatted }} @endif <svg class="place-page_arrow-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="100px" width="100px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"> <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/> </g></svg></div>
                    </div>
                    @else
                    <div class="place-page__shedule-inactive">График работы не указан</div>
                    @endif
                </div>
            </div>
            <div class="place-page__top-info-right">
                @auth
                    {{-- Пользователь авторизован --}}
                    <button class="favorite-btn {{ auth()->user()->favoritePlaces->contains($place->id) ? 'active' : '' }} favorite-btn-js" data-place-id="{{ $place->id }}">
                        <i class="fa-heart {{ auth()->user()->favoritePlaces->contains($place->id) ? 'fas' : 'far' }}"></i>
                    </button>
                @else
                    {{-- Пользователь не авторизован --}}
                    <button class="favorite-btn favorite-btn-js" data-place-id="{{ $place->id }}">
                        <i class="far fa-heart"></i>
                    </button>
                @endauth
                <img class="place-page__main-img" src="@if($place->image_src == null) /img/admin/no-image.png @else {{ $place->image_src }} @endif" alt="{{ $place->image_alt }}">
            </div>
        </div>
        <div class="place-page__description-block place-page__block-space place-page__block-max-width">
            <h2 class="place-page_h2">Описание места</h2>
            <div class="place-page__description expandable-text">
                {!! $place->description !!}
            </div>
        </div>
        @if($images->count() != 0)
        <div class="place-page__images-block place-page__block-space">
            @foreach($images->take(5) as $index => $elem)
            <div data-fancybox="gallery" data-index="{{ $index }}"  href="{{ $elem->image_src }}" class="place-page__images-elem">
                <img src="{{ $elem->thumb_image_src }}" alt="">
            </div>
            @endforeach
            @if($images->count() > 5)
            <div data-index="{{ $index + 1 }}" data-fancybox="gallery" class="place-page__images-last">
                +{{$images->count() - 5}}
            </div>
            @endif
        </div>
        @endif
        @if($place->kitchens->count() != 0)
            <div class="place-page__kitchen-block place-page__block-space place-page__block-max-width">
            <h2 class="place-page_h2">Кухня</h2>
            <div class="place-page__kitchen-row">
                @foreach($place->kitchens as $kitchen)
                <div>{{ $kitchen->name }}@if(!$loop->last), @endif</div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="place-page__map-block place-page__block-space">
            <h2 class="place-page_h2">Адрес</h2>
            <div class="mb-2">{{ $place->address }}</div>
            <div  class="place-page__map" id="map"></div>
        </div>
       
    </div>
</div>

{{-- @push('scripts')
    @vite(['resources/js/fancybox.js'])
@endpush --}}

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        ymaps.ready(initMap);
    });

    function initMap() {
        const map = new ymaps.Map('map', {
            center: [{{ $place->latitude }}, {{ $place->longitude }}], // Москва по умолчанию
            zoom: 15
        });

        const placemark = new ymaps.Placemark(map.getCenter(), {}, {
            draggable: true,
            preset: 'islands#redDotIcon',
        });

        map.geoObjects.add(placemark);
        
    }
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const photos = @json($images);
    console.log(photos[0]['image_src']);
    const gallerySelector = '[data-fancybox="gallery"]';
    
    // Показываем только первые 6
    const previewContainer = document.querySelector('.gallery-preview');

    document.querySelectorAll(gallerySelector).forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            const clickedIndex = parseInt(e.currentTarget.getAttribute('data-index'));
            
            // Формируем массив всех фото для Fancybox
            const fancyboxItems = photos.map(photo => ({
                src: photo.image_src,
                thumb: photo.thumb_image_src,
                type: 'image',
            }));

            // Открываем галерею с нужным индексом
            Fancybox.show(fancyboxItems, {
                Thumbs: {
                    type: 'classic',
                },
                startIndex: clickedIndex,
                Image: {
                    zoom: true, // Включить/выключить зум
                    wheel: true, // Зум колесиком мыши
                    click: true, // Зум кликом
                    dblclick: true, // Двойной клик для 100% масштаба
                    wheelSensitivity: 1, // Скорость зума колесом
                    maxZoom: 5, // Максимальный зум (1-20)
                    minZoom: 0.1, // Минимальный зум
                    fit: "contain", // "contain" или "cover"
                    ratio: 1, // Соотношение (1 = оригинальное)
            },
    
            // Дополнительные элементы интерфейса
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                    ],
                    right: ["slideshow", "download", "thumbs", "close"],
                },
            },
                // Другие настройки...
            });
        });
           });
});

</script>


<script type="module">
$(document).ready(function() {
  
	$('.favorite-btn-js').click(function(e) {
        e.preventDefault();
        e.stopPropagation(); 
        const placeId = this.dataset.placeId;
        toggleFavorite(placeId, this);
    });

    function toggleFavorite(placeId, button) {

        $.ajax({
			headers: {
             	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			type: 'POST',
			url: `/places/${placeId}/favorite/toggle`, 
		}).done(function (data) {
			if (data.status === 'added') {
                $('.fav-count-js').addClass('active');
                $('.fav-count-js').html(data.favCount);
                button.innerHTML = '<i class="fas fa-heart"></i>';
                button.classList.add('active', 'active-anim');
            }
            else if(data.status === 'notauth'){
                Swal.fire(
				'Ошибка!',
				'Составляете список? Пожалуйста войдите в аккаунт или зарегистрируйтесь',
				'error'
			)
            }
             else {
                if(data.favCount == 0){
                    $('.fav-count-js').removeClass('active');
                }
                $('.fav-count-js').html(data.favCount);
                button.innerHTML = '<i class="far fa-heart"></i>';
                button.classList.remove('active', 'active-anim');
            }
		}).fail(function () {
			Swal.fire(
				'Ошибка!',
				'Неизвестная ошибка',
				'error'
			)
		});
    }

	
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(function(popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      container: 'body'
    });
  });
});
</script>

<script type="module">
$('.place-page__shedule').on('click', function() {
    $(this).find('svg').toggleClass('rotated');
  });
</script>

<script type="module">
    $(document).ready(function() {
    $('.expandable-text').expander({
        slicePoint: 400, // максимальная высота в пикселях
        expandText: 'Показать полностью',
        userCollapseText: 'Свернуть',
        expandEffect: 'fadeIn',
        collapseEffect: 'fadeOut'
    });
});
</script>

<script src="/libs/swal/dist/sweetalert2.min.js"></script>

@endsection