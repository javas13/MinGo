@extends('layouts.main')

@section('title', $news->seo_name)
@section('description', $news->seo_description)	
@section('canonical', 'https://sportsfera.pro/news/'.$news->id)	
@section('ogTitle', $news->seo_name)
@section('ogDescription', $news->seo_description)
@section('ogImage', $news->image_src)	

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>

<div class="news-elem-page">
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
		<h1 class="welcome-page__title">{{ $news->name }}</h1>
		<div class="news-elem-page__news-text">{!! $news->text !!}</div>
	</div>
	<div id="loader" class="loader">
		<div class="spinner"></div>
	</div>
</div>

<script type="module">
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