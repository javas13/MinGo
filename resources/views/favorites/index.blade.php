@extends('layouts.main')

@section('title', 'Избранное - MinGo')
@section('description', 'Избранное пользователя - MinGo')	
@section('canonical', 'https://mingonow.ru/favorites')
@section('ogTitle', 'Избранное - MinGo')
@section('ogDescription', 'Избранное - MinGo')	

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>


<div class="places-favorites-page">
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
        <h1 class="page-title">Избранное</h1>
        @isset($error)
        <div class="places-favorites-page__error-container">
            <div class="places-favorites-page__error-subtitle">Чтобы добавлять заведения в избранное, пожалуйста войдите в аккаунт 😄</div>
            <a class="btn-main-a" href="{{ route('login') }}">Войти</a>
            <a class="btn-main-a" href="{{ route('register') }}">Зарегистрироваться</a>
        </div>
        @include('partials.kviz')
        @endisset
        @empty($error)
        @if($places->total() == 1)
            <div class="places-results-page__count-places">У вас: <span class="places-favorites-page__fav-count-js">1</span> заведение в избранном</div>
        @elseif($places->total() > 1 && $places->total() < 5)
            <div class="places-results-page__count-places">У вас: <span class="places-favorites-page__fav-count-js">{{ $places->total() }}</span> заведения в избранном</div>
        @else
            <div class="places-results-page__count-places">У вас: <span class="places-favorites-page__fav-count-js">{{ $places->total() }}</span> заведений в избранном</div>
        @endif
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
    $(document).ready(function() {
      
        $('.favorite-btn-js').click(function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            const placeId = this.dataset.placeId;
            const cardElement = $(this).closest('.place-card').parent(); // Находим родительский элемент карточки
            toggleFavorite(placeId, this, cardElement);
        });
    
        function toggleFavorite(placeId, button, cardElement) {
    
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
                    $('.places-favorites-page__fav-count-js').html(data.favCount);
                    $('.fav-count-js').html(data.favCount);
                    cardElement.css('transition', 'all 0.3s ease');
                    cardElement.css('opacity', '0');
                    cardElement.css('transform', 'translateX(-100px)');

                    setTimeout(() => {
                        cardElement.remove();
                        
                        // Если это страница избранного и карточек не осталось, показываем сообщение
                        if (window.location.pathname.includes('favorites') && $('.place-results-list').children().length === 0) {
                            $('.place-results-list').html('<div class="empty-favorites">Ваш список избранного пуст</div>');
                        }
                    }, 300);

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

@endsection