@extends('layouts.main')

@section('title', 'Контакты - Sportsfera')
@section('description', 'Нужно организовать спортивный сбор? Свяжитесь с нами проведения для тренировочного мероприятия.')	
@section('canonical', 'https://sportsfera.pro/contacts')


@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>
<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=b8f2ff2a-587d-47e2-b259-be60d9c2e7f2&load=package.full&lang=ru-RU" type="text/javascript"></script>

<div class="contacts-page">
	<div class="container-v1">
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
		<h1 class="welcome-page__title">Контакты</h1>
		<div class="contacts-page__content">
			<div class="contacts-page__content-left">
				<div class="contacts-page__content-col-elem">
					<div class="contacts-page__content-title">Менеджер</div>
					<a class="contacts-page__content-link-text" target="_blank" href="tel:+79503201921">+7 950 320-19-21</a>
					<a class="contacts-page__content-link-text" target="_blank" href="tel:+79867277843">+7 986 727-78-43</a>
				</div>
				<div class="contacts-page__content-col-elem">
					<div class="contacts-page__content-title">Электронная почта</div>
					<a class="contacts-page__content-link-text" target="_blank" href="mailto:info@sportsfera.pro">info@sportsfera.pro</a>
				</div>
				<div class="contacts-page__content-col-elem">
					<div class="contacts-page__content-title">Адрес</div>
					<div class="contacts-page__content-link-text">г. Казань, ул. Исаева 10, офис 305, 309</div>
				</div>
				<div class="contacts-page__content-col-elem">
					<div class="contacts-page__content-title">Социальные сети</div>
					<div class="contacts-page__socials-row">
						<a rel="nofollow" target="_blank" href="https://www.instagram.com/sportsfera_kzn?igsh=YnFjNzd2bDkzdHFi">
							<img src="/img/insta.svg" alt="">
						</a>
						<a rel="nofollow" target="_blank" href="https://vk.com/sportsfera_kzn">
							<img src="/img/vk-big.svg" alt="">
						</a>
						<a rel="nofollow" target="_blank" href="https://www.youtube.com/@SportSferaclub">
							<img src="/img/yt-big.svg" alt="">
						</a>
					</div>
				</div>
			</div>
			<div class="contacts-page__content-right">
				<form class="feedback-form feedback-form-js" method="POST" action="{{ route('send.feedback.telegram') }}">
					<div class="feedback-form__title">Оставьте ваш вопрос, и мы свяжемся с вами в течение 24 часов.</div>
					<input class="feedback-form__input" type="name" name="name" placeholder="Имя">
					<input class="feedback-form__input" name="phone" type="phone" placeholder="Номер телефона">
					<textarea class="feedback-form__input feedback-form__textarea" placeholder="Ваш вопрос" name="descript"></textarea>
					<button class="feedback-form__btn">Отправить</button>
				</form>
			</div>
		</div>
		<div class="contacts-page__map-block">
			<div class="contacts-page__map" id="myMap">

			</div>
		</div>
	</div>
	<div id="loader" class="loader">
		<div class="spinner"></div>
	</div>
</div>

<script type="module">
let formOrigin = 'Заявка со страницы - Контакты';

$(".feedback-form-js").submit(function (e) {
			showLoader();
            $.ajax({
            type: 'Post',
            url: '{{ route('send.feedback.telegram')}}',
            data: {"_token": "{{ csrf_token() }}", dataForm: $(".feedback-form-js").serialize(), fromWhere: formOrigin},
        }).done(function (data) {
			hideLoader();
			Swal.fire(
                'Заявка отправлена успешно!',
                'Мы свяжемся с вами в ближайшее время!',
                'success'
             )
        }).fail(function () {
			hideLoader();
			Swal.fire(
                'Ошибка!',
                'Неизвестная ошибка',
                'error'
             )
        });
        e.preventDefault();
    });

	function showLoader() {
	document.getElementById('loader').style.display = 'flex';
}

// Функция для скрытия индикатора загрузки
function hideLoader() {
	document.getElementById('loader').style.display = 'none';
}

$(document).ready(function(){
  ymaps.ready(init);
  function init(){
    // Создание карты.
    var myMap = new ymaps.Map("myMap", {
      center: [55.83399156890942, 49.06730149999996],
      zoom: 17
    });
    var myPlacemark = new ymaps.Placemark([55.83389156890942, 49.06710149999996], {}, {
    iconLayout: 'default#image',
    iconImageHref: '/img/map-placemark.svg',
    iconImageSize: [63.32, 25.82],
});
    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable('scrollZoom');
    /*
    var address = "г. Казань, ул. Краснококшайская, д.81";

    var geocoder = ymaps.geocode(address);
    geocoder.then(
      function (res) {
        var coordinates = res.geoObjects.get(0).geometry.getCoordinates();
        myMap.setCenter(coordinates);
        var myPlacemark = new ymaps.Placemark(
        // Координаты метки
          coordinates
        );
        myMap.geoObjects.add(myPlacemark);
      }
    );
    */
    $('#map').bind('mousewheel', function(e){

      if(e.ctrlKey){
        //myMap.behaviors.enable('scrollZoom');
      }
      if(e.originalEvent.wheelDelta /120 > 0) {
        console.log('scrolling up !');
      }
      else{
        console.log('scrolling down !');
      }
    });
  }
})
</script>

@endsection