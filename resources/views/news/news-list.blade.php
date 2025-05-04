@extends('layouts.main')

@section('title', 'Новости - Sportsfera')
@section('description', 'Здесь мы выкладываем новости спорта, информацию о новых спортивных базах, полезные статьи для спортсменов и не только!')	
@section('canonical', 'https://sportsfera.pro/news')	
@section('ogTitle', 'Новости - Sportsfera')
@section('ogDescription', 'Здесь мы выкладываем новости спорта, информацию о новых спортивных базах, полезные статьи для спортсменов и не только!')


@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>

<div class="news-page">
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
		<h1 class="welcome-page__title">Новости</h1>
		<div class="newsletter-banner">
			<div class="newsletter-banner__title">Получайте актуальные предложения и новости первыми, подпишитесь на нашу рассылку!</div>
			<div class="kviz-banner__btn newsletter-banner_btn-js">Подписаться</div>
		</div>
		<div class="news-page__news-groups">
			<div class="accordion" id="accordionExample">

				<div class="accordion-item faq-accordion-item news-accordion-item">
					<h2 class="accordion-header">
					  <button class="accordion-button faq-accordion-button news-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFirstMonth" aria-expanded="false" aria-controls="collapseFirstMonth">
						  {{ $lastMonth['date'] }}
					  </button>
					</h2>
					<div id="collapseFirstMonth" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
					  <div class="accordion-body faq-accordion-body news-accordion-body">
						  <div class="news-page__news-list">
							  @foreach($lastMonthNews as $newsElem)
							    @if ($loop->first)
								<div href="#" class="news-page__news-elem news-page__news-elem-large">
									<a class="news-page__news-elem-link-over" href="@if($newsElem->is_social == 1) {{ $newsElem->link }} @else {{ route('news.elem', $newsElem->id) }} @endif"></a>
									<img class="news-page__news-elem-img" src="{{ $newsElem->image_src }}" alt="">
									<div class="news-page__news-elem-top-row">
										<div class="news-page__news-elem-date">{{ $newsElem->created_at->format('d.m.Y') }}</div>
										<div class="news-page__news-elem-btn" href="">
											<img src="/img/news-arrow.svg" alt="">
										</div>
									</div>
									<h2 class="news-page__news-elem-title news-page__news-elem-large">{{ $newsElem->name }}</h2>
								</div>
								@elseif ($loop->index == 3)
								<div href="#" class="news-page__news-elem news-page__news-elem-long">
									<a class="news-page__news-elem-link-over" href="@if($newsElem->is_social == 1) {{ $newsElem->link }} @else {{ route('news.elem', $newsElem->id) }} @endif"></a>
									<img class="news-page__news-elem-img" src="{{ $newsElem->image_src }}" alt="">
									<div class="news-page__news-elem-top-row">
										<div class="news-page__news-elem-date">{{ $newsElem->created_at->format('d.m.Y') }}</div>
										<div class="news-page__news-elem-btn" href="">
											<img src="/img/news-arrow.svg" alt="">
										</div>
									</div>
									<h2 class="news-page__news-elem-title">{{ $newsElem->name }}</h2>
								</div>
								@else
								<div href="#" class="news-page__news-elem">
									<a class="news-page__news-elem-link-over" href="@if($newsElem->is_social == 1) {{ $newsElem->link }} @else {{ route('news.elem', $newsElem->id) }} @endif"></a>
									<img class="news-page__news-elem-img" src="{{ $newsElem->image_src }}" alt="">
									<div class="news-page__news-elem-top-row">
										<div class="news-page__news-elem-date">{{ $newsElem->created_at->format('d.m.Y') }}</div>
										<div class="news-page__news-elem-btn" href="">
											<img src="/img/news-arrow.svg" alt="">
										</div>
									</div>
									<h2 class="news-page__news-elem-title">{{ $newsElem->name }}</h2>
								</div>
								@endif
							  @endforeach
						  </div>
					  </div>
					</div>
				  </div>

				  @foreach($months as $elem)
				  <div data-month='{{ $elem['month'] }}' data-year='{{ $elem['year'] }}' class="accordion-item faq-accordion-item news-accordion-item news-accordion-click-js">
					<h2 class="accordion-header">
					  <button class="accordion-button faq-accordion-button news-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $elem['id'] }}" aria-expanded="false" aria-controls="collapseOne{{ $elem['id'] }}">
						{{ $elem['date'] }}
					  </button>
					</h2>
					<div id="collapseOne{{ $elem['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
					  <div class="accordion-body faq-accordion-body news-accordion-body">
						  <div class="news-page__news-list news-page__news-list-js">
							  
						  </div>
					  </div>
					</div>
				  </div>
				  @endforeach
			</div>
		</div>
	</div>
	<div id="loader" class="loader">
		<div class="spinner"></div>
	</div>
	<div class="feedback-window feedback-window-js">
		<div class="feedback-window__wrap">
			<div class="feedback-window__content newsletter-window__content">
				<div class="feedback-window__close-btn feedback-window__close-btn-js">
					<img src="/img/close.svg" alt="">
				</div>
				<div class="feedback-window__title">Чтобы быть вкурсе всех наших новостей первыми, подпишитесь на нашу рассылку</div>
				<form class="feedback-form newsletter-subscriptions-form-js" action="">
					<input class="feedback-form__input" type="mail" name="mail" placeholder="Почта">
					<button class="feedback-form__btn">Подписаться</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="module">

$(".newsletter-subscriptions-form-js").submit(function (e) {
			showLoader();
            $.ajax({
            type: 'Post',
            url: '{{ route('subscribe.newsletter')}}',
            data: {"_token": "{{ csrf_token() }}", dataForm: $(".newsletter-subscriptions-form-js").serialize()},
        }).done(function (data) {
			hideLoader();
			document.querySelector('.feedback-window-js').classList.remove('open');
			if(data.mailExist == true){
				Swal.fire(
                'Ошибка!',
                'Такая почта уже подписана на рассылку!',
                'error'
             )
			}
			else{
				Swal.fire(
                'Успешно!',
                'Вы подписались на рассылку!',
                'success'
             )
			}
        }).fail(function () {
			hideLoader();
			document.querySelector('.feedback-window-js').classList.remove('open');
			Swal.fire(
                'Ошибка!',
                'Неизвестная ошибка',
                'error'
             )
        });
        e.preventDefault();
    });


	$('.newsletter-banner_btn-js').click(function() {
		document.querySelector('.feedback-window-js').classList.add('open');
	});
	function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }
    
    // Функция для скрытия индикатора загрузки
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }
	$(".news-accordion-click-js").click(function (e) {
		    if($(this).hasClass("loaded") == false){
				    showLoader();
					let bodyForNews = $(this).find('.news-page__news-list-js');
					$(this).addClass('loaded');
					$.ajax({
					type: 'Get',
					url: '{{ route('news.for.month')}}',
					data: { month: e.currentTarget.dataset.month, year: e.currentTarget.dataset.year },
				}).done(function (data) {
					setTimeout(function() {
						hideLoader(); // Скрываем индикатор после завершения
						bodyForNews.append(data.html);
					}, 1000); // Задержка
				}).fail(function () {
					Swal.fire(
						'Ошибка!',
						'Неизвестная ошибка',
						'error'
					)
				});
				e.preventDefault();
			}
    });
</script>

@endsection