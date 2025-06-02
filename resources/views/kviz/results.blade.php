@extends('layouts.main')

@section('title', 'Результаты квиза — MinGo')
@section('description', 'Результаты квиза из самых разных заведений — MinGo')
@section('ogTitle', 'Результаты квиза — MinGo')
@section('ogDescription', 'Результаты квиза из самых разных заведений — MinGo')	

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
@isset($error) 
@vite(['resources/js/kviz.js'])
@endisset



<div class="places-results-page @isset($error) places-results-error-page @endisset">
    <div class="container places-container">
        @isset($error)
        <div class="places-results-page__error-container">
            <h1 class="page-title places-results-title">Данная ссылка устарела<img class="places-results-page__emodji" src="/img/emodji/mood/sad.png" alt=""> <br>Пройдите квиз заново для получения результатов</h1>
            <div class="places-results-page__error-subtitle">Чтобы сохранять места, добавляйте их в избранное</div>
            <button data-bs-toggle="modal" data-bs-target="#quizModal" class="go-btn">GO</button>
        </div>
        @include('partials.kviz')
        @endisset
        @empty($error)
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
        <h1 class="page-title">Ваши места исходя из квиза <span class="emoji"><img class="places-results-page__emodji" src="/img/emodji/mood/happy.png" alt=""></span></h1>
        @if($places->total() == 1)
            <div class="places-results-page__count-places">Найдено: <span>1</span> место</div>
        @elseif($places->total() > 1 && $places->total() < 5)
            <div class="places-results-page__count-places">Найдено: <span>{{ $places->total() }}</span> места</div>
        @else
            <div class="places-results-page__count-places">Найдено: <span>{{ $places->total() }}</span> мест</div>
        @endif
        <div class="mt-1">Вы можете получить доступ к списку мест по ссылке в течении 60 минут с момента прохождения опроса</div>
        <div class="places-results-page__btn-cont">
          <div class="d-flex flex-row gap-2">
            <button data-copy-text="{{ url()->current() }}" class="copy-btn-js places-results-page__copy-btn mt-3 btn btn-primary"><i class="fas fa-copy"></i> Скопировать ссылку</button>
            <button class="places-results-page__copy-btn mt-3 btn btn-primary" data-bs-toggle="popover" title="Поделиться в соц сетях" data-bs-placement="top" data-bs-template='<div class="popover share-place-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-body d-flex flex-column"></div></div>' data-bs-html="true" data-bs-content='@include('partials.share-place')'><i class="fas fa-share-alt"></i> Поделиться</button>
          </div>
          <button data-for-window-id="filters-window" class="mt-3 filters-btn window-open-trigger-js"><i class="fas fa-filter"></i> Фильтры</button>
        </div>
        <div class="place-results-list">
            <!-- Карточка 1 -->
            @foreach($places as $place)
                @include('partials.place-card')
            @endforeach
        </div>
        <div class="custom-pagination">
            {{ $places->appends($_GET)->links() }}
          </div>
        @endempty
        
    </div>
</div>

@empty($error)
@include('partials.filters-window')
@endempty

@include('partials.kviz-loader')

<script type="module">
        $(document).ready(function() {
            // Инициализация ползунка
            const priceSlider = document.getElementById('priceSlider');
            const minPriceInput = document.getElementById('minPrice');
            const maxPriceInput = document.getElementById('maxPrice');
            
            const minValue = 100;
            const maxValue = 20000;
            const step = 100;

            const initialMin = parseInt(minPriceInput.value) || 100;
            const initialMax = parseInt(maxPriceInput.value) || 20000;
            
            noUiSlider.create(priceSlider, {
                start: [initialMin, initialMax],
                connect: true,
                range: {
                    'min': minValue,
                    'max': maxValue
                },
                step: step,
                // Убрана строка с tooltips
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });
            
            // Обновление input полей при изменении ползунка
            priceSlider.noUiSlider.on('update', function(values, handle) {
                const value = values[handle];
                if (handle) {
                    maxPriceInput.value = value;
                } else {
                    minPriceInput.value = value;
                }
            });
            
            // Обновление ползунка при изменении input полей
            minPriceInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([this.value, null]);
            });
            
            maxPriceInput.addEventListener('change', function() {
                priceSlider.noUiSlider.set([null, this.value]);
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

@endsection
