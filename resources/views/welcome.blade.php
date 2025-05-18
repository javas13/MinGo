@extends('layouts.main')

@section('title', 'MinGo — Поиск ресторанов, баров и не только! Москва')
@section('description', 'MinGo — Это место, где ответив 5 вопросов вы получаете список заведений по вашим предпочтениям, рестораны, бары, кино, бани и не только!')
@section('canonical', 'https://mingonow.ru/')
@section('ogTitle', 'MinGo — Поиск ресторанов, баров и не только!')
@section('ogDescription', 'MinGo — Это место, где ответив 5 вопросов вы получаете список заведений по вашим предпочтениям, рестораны, бары, кино, бани и не только!')	

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>
@vite(['resources/js/kviz.js'])

<!-- Главный экран -->
<section class="hero-section">
	<div class="decor-circle circle-1"></div>
	<div class="decor-circle circle-2"></div>
	
	<div class="container">
		<div class="hero-content">
			<h1 class="display-4 fw-bold mb-4">Найди идеальное место за 60 секунд</h1>
			<p class="lead mb-5">Персонализированный подбор подходящих мест по вашим предпочтениям</p>
			<button data-bs-toggle="modal" data-bs-target="#quizModal" class="go-btn">GO</button>
		</div>
	</div>
</section>

@include('partials.kviz')

@include('partials.kviz-loader')



@endsection
