@extends('layouts.main')

@section('title', 'Профиль - MinGo')
@section('description', 'Профиль пользователя - MinGo')	
@section('canonical', 'https://mingonow.ru/profile/settings')
@section('ogTitle', 'Профиль - MinGo')
@section('ogDescription', 'Профиль - MinGo')	


@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>


<div class="profile-settings-page">
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
        <h1 class="page-title">Настройки профиля</h1>
        <div class="profile__main-row">
            <div class="profile__navigation-col">
                <ul class="profile__navigation-ul">
                    <li class="profile__navigation-li">
                        <a class="profile__navigation-link-item" href="{{ route('favorites') }}">
                            <i class="fas fa-heart profile__navigation-icon"></i>
                            <span>Избранное</span>
                        </a>
                    </li>
                    <li class="profile__navigation-li active">
                        <a class="profile__navigation-link-item" href="{{ route('profile') }}">
                            <i class="fas fa-wrench profile__navigation-icon"></i>
                            <span>Настройки профиля</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="profile__content">
                <div class="profile-settings-page__top-info">
                <div class="profile-settings-page__avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 129 129" enable-background="new 0 0 129 129">
                    <g>
                        <g>
                        <path d="m64.3,71.6c18,0 32.6-14.6 32.6-32.6s-14.6-32.5-32.6-32.5-32.6,14.6-32.6,32.5 14.6,32.6 32.6,32.6zm0-56.6c13.2,0 24,10.8 24,24s-10.8,24-24,24-24-10.8-24-24 10.8-24 24-24z"/>
                        <path d="m7.9,122.5h113.2c2.4,0 4.3-1.9 4.3-4.3 0-22.5-18.3-40.9-40.9-40.9h-40c-22.5,0-40.9,18.3-40.9,40.9-1.33227e-15,2.4 1.9,4.3 4.3,4.3zm36.6-36.6h40c16.4,0 29.9,12.2 32,28h-104c2.1-15.7 15.6-28 32-28z"/>
                        </g>
                    </g>
                    </svg>
                </div>
                <div>
                    <div class="profile-settings-page__user-name profile-name-js">{{ $user->name }}</div>
                    <div>Дата регистрации: {{ $user->created_at->format('d.m.Y') }}</div>
                </div>
                </div>
                <div class="profile-settings-page__input-list">
                    <div>
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" data-field="name"  data-url="{{ route('profile.auto-update') }}" class="auto-update-field-js form-control beaty-input @error('name') is-invalid @enderror" id="name" name="name" placeholder="Имя" value="{{old('name', $user->name)}}" required>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control beaty-input @error('email') is-invalid @enderror" id="email" name="email" placeholder="Введите ваш email" value="{{old('email', $user->email)}}" required>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-content">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="loading-text mt-3">Обновляем данные...</p>
    </div>
</div>

<script>
    document.querySelectorAll('.auto-update-field-js').forEach(input => {
    input.dataset.originalValue = input.value;
    input.addEventListener('blur', async function() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        const field = this.dataset.field;
        const url = this.dataset.url;
        const value = this.value;
        const originalValue = this.dataset.originalValue;

        if (value === originalValue) {
            return;
        }

        loadingOverlay.style.display = 'flex';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ field, value }),
            });

            const data = await response.json();

            document.querySelector('.profile-name-js').innerHTML = value;
            
            if (response.ok) {
                // Обновляем originalValue на новое, чтобы при повторном blur не отправлять запрос
                this.dataset.originalValue = value;
            } else {
                this.value = originalValue; // Откатываем значение
                console.error('Ошибка:', data.message);
            }
        } catch (error) {
            this.value = originalValue;
            console.error('Ошибка сети:', error);
        } finally {
            loadingOverlay.style.display = 'none';
        }
    });
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