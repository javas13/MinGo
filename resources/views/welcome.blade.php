@extends('layouts.main')

@section('title', 'Sportsfera - организация спортивных сборов')
@section('description', 'Мы занимается организацией спортивных сборов во всех городах России. Не тратьте время на поиск базы, потратьте его на спорт!')	
@section('canonical', 'https://sportsfera.pro/')

@section('content')

<link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
<script src="/libs/swal/dist/sweetalert2.min.js"></script>

<!-- Главный экран -->
<section class="hero-section">
	<div class="decor-circle circle-1"></div>
	<div class="decor-circle circle-2"></div>
	
	<div class="container">
		<div class="hero-content">
			<h1 class="display-4 fw-bold mb-4">Найди идеальное место за 60 секунд</h1>
			<p class="lead mb-5">Персонализированный подбор ресторанов и баров по вашим предпочтениям</p>
			<button data-bs-toggle="modal" data-bs-target="#quizModal" class="go-btn">GO</button>
		</div>
	</div>
</section>

<div class="modal fade" id="quizModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<form id="quizForm" action="{{ route('kviz.search') }}" method="POST" class="modal-content">
			@csrf
			<div class="modal-header border-0">
				<h3 class="modal-title fw-bold text-success">Быстрый подбор</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="quiz-step active">
					<div class="question mb-5">
						<h5 class="mb-4">1. Какое у тебя настроение?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="sad" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="😢">
									<span class="text">Грустное</span>
									<span class="emoji">😢</span>
								</button>
								<input type="radio" name="mood" value="sad" hidden>
							</div>
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="normal" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="😐">
									<span class="text">Нормальное</span>
									<span class="emoji">😐</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button type="button" data-question="mood" data-value="happy" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="😄">
									<span class="text">Весёлое</span>
									<span class="emoji">😄</span>
								</button>
							</div>
						</div>
					</div>
					
					<div class="question mb-5">
						<h5 class="mb-4">2. С кем пойдёшь?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="alone" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="🧍">
									<span class="text">Один</span>
									<span class="emoji">🧍</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="family" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="👪">
									<span class="text">Семья</span>
									<span class="emoji">👪</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="date" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="💑">
									<span class="text">Свидание</span>
									<span class="emoji">💑</span>
								</button>
							</div>
							<div class="col-6 col-md-3">
								<button type="button" data-question="company" data-value="friends" onclick="selectAnswer(this)" class="btn btn-option w-100 py-3" data-emoji="👫">
									<span class="text">Друзья</span>
									<span class="emoji">👫</span>
								</button>
							</div>
						</div>
					</div>

					<div class="question mb-5">
						<h5 class="mb-4">3. Что хочешь сделать?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="eat" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🍽️">
									<span class="text">Поесть</span>
									<span class="emoji">🍽️</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="walk" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🚶">
									<span class="text">Погулять</span>
									<span class="emoji">🚶</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="activity" data-value="rest" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🛋️">
									<span class="text">Отдохнуть</span>
									<span class="emoji">🛋️</span>
								</button>
							</div>
						</div>
					</div>
				
					<!-- Новый вопрос 4 -->
					<div class="question mb-5">
						<h5 class="mb-4">4. Какой бюджет? </h5>
						<div class="row g-2">
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="1000" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="💰1">
									<span class="text">до 1000₽</span>
									<span class="emoji">💰</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="1500" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="💰2">
									<span class="text">1000-1500₽</span>
									<span class="emoji">💰</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="2000" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="💰3">
									<span class="text">1500-2000₽</span>
									<span class="emoji">💰</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="3000" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="💰4">
									<span class="text">2000-3000₽</span>
									<span class="emoji">💰</span>
								</button>
							</div>
							<div class="col-6 col-md-2-4">
								<button data-question="budget" data-value="3000+" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="💰5">
									<span class="text">от 3000₽</span>
									<span class="emoji">💰</span>
								</button>
							</div>
						</div>
					</div>
				
					<!-- Новый вопрос 5 -->
					<div class="question">
						<h5 class="mb-4">5. Какая атмосфера?</h5>
						<div class="row g-3">
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="quiet" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🔕">
									<span class="text">Тихое место</span>
									<span class="emoji">🔕</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="noisy" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🔊">
									<span class="text">Шумное место</span>
									<span class="emoji">🔊</span>
								</button>
							</div>
							<div class="col-6 col-md-4">
								<button data-question="atmosphere" data-value="any" onclick="selectAnswer(this)" type="button" class="btn btn-option w-100 py-3" data-emoji="🤷">
									<span class="text">Без разницы</span>
									<span class="emoji">🤷</span>
								</button>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer border-0">
				<button type="submit" id="searchButton" class="btn btn-primary px-5 py-2">GO</button>
			</div>
		</form>
	</div>
</div>

<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-content">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="loading-text mt-3">Подбираем ваши заведения...</p>
    </div>
</div>

<script>
function selectAnswer(button) {
    const questionGroup = button.closest('.question');
    
    // Снимаем выделение со всех кнопок вопроса
    questionGroup.querySelectorAll('.btn-option').forEach(btn => {
        btn.classList.remove('selected');
        btn.dataset.selected = "false";
    });
    
    // Выделяем текущую кнопку
    button.classList.add('selected');
    button.dataset.selected = "true";
}
</script>

<script type="module">
$(document).ready(function() {
  
  $("#quizForm").submit(function(e) {
    e.preventDefault();
	const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.style.display = 'flex';
    
    // Отключаем кнопку отправки
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Обработка...';

    // Собираем данные из выбранных ответов
    const formData = new FormData();
    const allQuestions = document.querySelectorAll('.question');

	let requiredError = '';
    
    allQuestions.forEach((question, index) => {
        const selectedBtn = question.querySelector('.btn-option[data-selected="true"]');
        if (!selectedBtn) {
			loadingOverlay.style.display = 'none';
			submitBtn.disabled = false;
			submitBtn.textContent = 'Найти места';
            Swal.fire(
				'Ошибка!',
				'Пожалуйста ответьте на все вопросы',
				'error'
			)
			requiredError = 'error';
            return;
        }
        
        formData.append(selectedBtn.dataset.question, selectedBtn.dataset.value);
    });

	if(requiredError != ''){
		return;
	}

	$.ajax({
			headers: {
             	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			type: 'POST',
			url: '{{ route('kviz.search') }}',
			data: formData,
			processData: false,
  			contentType: false  
		}).done(function (data) {
			setTimeout(function() {
				loadingOverlay.style.display = 'none';
				submitBtn.disabled = false;
				submitBtn.textContent = 'Найти места';
				window.location.href = data.data;
			}, 1000);
		}).fail(function () {
			setTimeout(function() {
				loadingOverlay.style.display = 'none';
				submitBtn.disabled = false;
				submitBtn.textContent = 'Найти места';
				Swal.fire(
				'Ошибка!',
				'Неизвестная ошибка',
				'error'
			)
			}, 1000);
		});
  });
});
</script>

<script>


// Обработка отправки формы
// document.getElementById('quizForm').addEventListener('submit', function(e) {
//     e.preventDefault();

//     const loadingOverlay = document.getElementById('loadingOverlay');
//     loadingOverlay.style.display = 'flex';
    
//     // Отключаем кнопку отправки
//     const submitBtn = this.querySelector('button[type="submit"]');
//     submitBtn.disabled = true;
//     submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Обработка...';

//     // Собираем данные из выбранных ответов
//     const formData = new FormData();
//     const allQuestions = document.querySelectorAll('.question');
    
//     allQuestions.forEach((question, index) => {
//         const selectedBtn = question.querySelector('.btn-option[data-selected="true"]');
//         if (!selectedBtn) {
// 			loadingOverlay.style.display = 'none';
// 			submitBtn.disabled = false;
// 			submitBtn.textContent = 'Найти места';
//             Swal.fire(
// 				'Ошибка!',
// 				'Пожалуйста ответьте на все вопросы',
// 				'error'
// 			)
//             return;
//         }
        
//         formData.append(selectedBtn.dataset.question, selectedBtn.dataset.value);
//     });
    
//     // Добавляем CSRF-токен
//     formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);


    
//     // Отправка на сервер
//     fetch(this.action, {
//         method: 'POST',
//         body: formData,
//         headers: {
//             'Accept': 'application/json'
//         }
//     })
//     .then(response => response.json())
//     .then(data => {
// 		setTimeout(function() {
// 				loadingOverlay.style.display = 'none';
// 				submitBtn.disabled = false;
// 				submitBtn.textContent = 'Найти места';
// 			}, 1000);
//         // Обработка успешного ответа
//         // window.location.href = data.redirect_url;
//     })
//     .catch(error => {
//         setTimeout(function() {
// 				loadingOverlay.style.display = 'none';
// 				submitBtn.disabled = false;
// 				submitBtn.textContent = 'Найти места';
// 				Swal.fire(
// 				'Ошибка!',
// 				'Неизвестная ошибка',
// 				'error'
// 			)
// 			}, 1000);
//     });
// });
</script>

@endsection
