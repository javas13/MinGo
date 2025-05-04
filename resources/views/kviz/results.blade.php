@extends('layouts.main')

@section('title', 'Sportsfera - организация спортивных сборов')
@section('description', 'Мы занимается организацией спортивных сборов во всех городах России. Не тратьте время на поиск базы, потратьте его на спорт!')	
@section('canonical', 'https://sportsfera.pro/')

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>

<div class="container places-container places-results-page">
    <h1 class="page-title">Ваши заведения исходя из квиза <span class="emoji">😄</span></h1>
    @if($places->total() == 1)
        <div class="places-results-page__count-places">Найдено: <span>1</span> заведение</div>
    @elseif($places->total() > 1 && $places->total() < 5)
        <div class="places-results-page__count-places">Найдено: <span>{{ $places->total() }}</span> заведения</div>
    @else
        <div class="places-results-page__count-places">Найдено: <span>{{ $places->total() }}</span> заведений</div>
    @endif
    <div class="page-title-mbg mt-1">Вы можете получить доступ к заведением по ссылке в течении 60 минут с момента прохождения опроса</div>
    <div class="place-results-list">
        <!-- Карточка 1 -->
		@foreach($places as $place)
		<div class="">
            <div class="place-card">
				<a class="place-image-box" href="/">
					<img src="/{{ $place->thumb_image_src }}" class="place-image" alt="Ресторан">
					<button class="favorite-btn favorite-btn-js">
                        <i class="far fa-heart"></i>
                    </button>
				</a>
                <div class="place-body">
                    <h3 class="place-title">{{ $place->name }}</h5>
                    <div class="place-price">
                        <i class="fas fa-ruble-sign price-icon"></i>
                        <span>Средний чек: {{ $place->average_bill }}₽</span>
                    </div>
                    <p class="place-address">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $place->address }}
                    </p>
                </div>
            </div>
        </div>
		@endforeach
        {{-- <div class="col-md-4">
            <div class="place-card">
                <img src="https://source.unsplash.com/random/800x600/?restaurant" class="place-image" alt="Ресторан">
                <div class="place-body">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <h5 class="place-title">La Bella Italia</h5>
                    <div class="place-price">
                        <i class="fas fa-ruble-sign price-icon"></i>
                        <span>Средний чек: 1500₽</span>
                    </div>
                    <p class="place-address">
                        <i class="fas fa-map-marker-alt"></i>
                        ул. Гастрономическая, 15
                    </p>
                </div>
            </div>
        </div>

        <!-- Карточка 2 -->
        <div class="col-md-4">
            <div class="place-card">
                <img src="https://source.unsplash.com/random/800x600/?bar" class="place-image" alt="Бар">
                <div class="place-body">
                    <button class="favorite-btn active">
                        <i class="fas fa-heart"></i>
                    </button>
                    <h5 class="place-title">Sky Lounge Bar</h5>
                    <div class="place-price">
                        <i class="fas fa-ruble-sign price-icon"></i>
                        <i class="fas fa-ruble-sign price-icon"></i>
                        <span>Средний чек: 2500₽</span>
                    </div>
                    <p class="place-address">
                        <i class="fas fa-map-marker-alt"></i>
                        пр. Ночной, 42
                    </p>
                </div>
            </div>
        </div>

        <!-- Карточка 3 -->
        <div class="col-md-4">
            <div class="place-card">
                <img src="https://source.unsplash.com/random/800x600/?cafe" class="place-image" alt="Кафе">
                <div class="place-body">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                    <h5 class="place-title">Coffee & Books</h5>
                    <div class="place-price">
                        <i class="fas fa-ruble-sign price-icon"></i>
                        <span>Средний чек: 800₽</span>
                    </div>
                    <p class="place-address">
                        <i class="fas fa-map-marker-alt"></i>
                        ул. Книжная, 7
                    </p>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<script type="module">
    $(document).on('click', '.favorite-btn', function(event) {
        event.stopPropagation(); // Останавливаем всплытие события
        event.preventDefault();  // Предотвращаем действие по умолчанию (если кнопка внутри <a>)
        
        // Ваш код для добавления в избранное
        console.log('Добавлено в избранное');
});
  </script>

@endsection
