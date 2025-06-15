<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Title не указан')</title>
	<meta name="description" content="@yield('description', 'Описание не указано')">
	<meta property="og:title"
		content="@yield('ogTitle', 'MinGo — Поиск ресторанов, баров и не только!')">
	<meta property="og:description"
		content="@yield('ogDescription', 'MinGo — Это место, где ответив 5 вопросов вы получаете список заведений по вашим предпочтениям, рестораны, бары, кино, бани и не только!')">
    <meta property="og:site_name" content="MinGo">
    <meta property="og:type" content="website">
	<meta property="og:image" content="@yield('ogImage', '/img/annya.jpg')">
    <meta property="og:locale" content="ru_RU">
	<link rel="canonical" href="@yield('canonical', '')" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400;500;700&display=swap" rel="stylesheet">
	@vite(['resources/js/app.js', 'resources/css/app.css', 'resources/js/script.js', 'resources/libs/bootstrap/bootstrap.css', 'resources/css/main.css'])
</head>
<body>
    <!-- Шапка сайта -->
	<header>
		<nav class="navbar navbar-expand-lg navbar-light" id="mainNavbar">
			<div class="container">
                <div class="header__burger header__burger-js">
					<div class="header__burger-one"></div>
					<div class="header__burger-one"></div>
					<div class="header__burger-one"></div>
				</div>
				<a class="navbar-brand logo header-logo" href="/">
					<img src="/img/logo.jpg" alt="">
				</a>
                <div class="header__mobile-stub"></div>				
				<div class="header__right-nav collapse navbar-collapse" id="navbarNav">
					<div class=" ms-auto d-flex align-items-center">
						<a href="mailto:info@gastrofind.com" class="header__mail nav-link">
							<i class="fas fa-envelope me-2"></i>
							info@mingonow.ru
						</a>
						{{-- <a href="{{ route('favorites') }}" class="nav-link heart-link">
							<i class="fas fa-heart me-2 heart-icon" style="color: #ff3366;"></i>
							Избранное
						</a> --}}
                        <a href="{{ route('favorites') }}" class="nav-link heart-link">
                            <span class="icon-wrapper">
                                <i class="fas fa-heart heart-icon" style="color: #ff3366;"></i>
                                <span class="badge-count fav-count-js @auth @if(auth()->user()->favoritePlaces()->count() != 0) active @endif @endauth">@auth {{ auth()->user()->favoritePlaces()->count() }} @endauth</span>
                            </span>
                            <span class="header__fav-text">Избранное</span>
                        </a>
                        @auth
                            <div class="ms-auto d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center" 
                                            type="button" 
                                            id="profileDropdown" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <span class="header__profile-text">Профиль</span>
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile') }}">
                                                <i class="fas fa-user me-2"></i>Профиль
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger logout-js" href="#">
                                                <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <a href="/login" class="nav-link">
                                <i class="fas fa-user-circle me-2"></i>
                                Войти
                            </a>
                        @endauth
					</div>
				</div>
			</div>
		</nav>
        <div class="header__mobile-menu header__mobile-menu-js">
            <div class="header__mobile-close-btn header__mobile-close-btn-js">
                <img src="/img/close2.svg" alt="Иконка закрытия">
            </div>
			<nav class="header__mobile-menu-nav">
				{{-- <ul class="header__mobile-menu-nav-ul">
					<li>
						<a href="">Каталог баз</a>
					</li>
					<li>
						<a href="">Услуги</a>
					</li>
					<li>
						<a href="">О нас</a>
					</li>
					<li>
						<a href="">Новости</a>
					</li>
					<li>
						<a href="">Контакты</a>
					</li>
				</ul> --}}
                 @auth
                            <div class="ms-auto d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="header__mobile-profile btn btn-link nav-link dropdown-toggle d-flex align-items-center" 
                                            type="button" 
                                            id="profileDropdown2" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <span class="header__profile-text">Профиль</span>
                                    </button>
                                    
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown2">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile') }}">
                                                <i class="fas fa-user me-2"></i>Профиль
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger logout-js" href="#">
                                                <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <a href="/login" class="nav-link header__mobile-profile">
                                <i class="fas fa-user-circle me-2"></i>
                                Войти
                            </a>
                        @endauth
				<a class="header__mobile-mail" href="mailto:info@gastrofind.com" class="header__call-btn header__call-btn-mobile"><i class="fas fa-envelope me-2"></i>
							info@mingonow.ru</a>
			</nav>
		</div>
	</header>

	<div class="notification-container" id="notificationContainer"></div>
	
	<main class="page-content">
		@yield('content')
	</main>

	<div id="loader" class="loader">
		<div class="spinner"></div>
	</div>

    <footer class="bg-light pt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Колонка с лого и соцсетями -->
                <div class="col-md-4">
					<a class="footer-logo logo" href="/">
						<img src="/img/logo.jpg" alt="">
					</a>
                    <div class="social-links">
                        <a href="#" target="_blank" rel="nofollow" class="text-secondary me-3"><i class="fab fa-telegram-plane fa-lg"></i></a>
                        <a href="#" target="_blank" rel="nofollow" class="text-secondary me-3"><i class="fab fa-vk fa-lg"></i></a>
                        <a href="#" target="_blank" rel="nofollow" class="text-secondary me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                    <div class="footer__insta-alert">
                        * Meta - признана экстремистской организацией в РФ.
                    </div>
                </div>
    
                <!-- Колонка с пользовательскими ссылками -->
                <div class="col-md-4">
                    <h5 class="mb-3">Аккаунт</h5>
                    <ul class="list-unstyled">
                        @auth
                            <li class="mb-2">
                                <a href="{{ route('profile') }}" class="text-decoration-none text-dark">
                                    <i class="fas fa-user me-2"></i>Профиль
                                </a>
                            </li>
                            <li>
                                <a href="/logout" class="text-decoration-none text-dark logout-js">
                                    <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                </a>
                            </li>
                        @else
                            <li class="mb-2">
                                <a href="/login" class="text-decoration-none text-dark">
                                    <i class="fas fa-sign-in-alt me-2"></i>Войти
                                </a>
                            </li>
                            <li>
                                <a href="/register" class="text-decoration-none text-dark">
                                    <i class="fas fa-user-plus me-2"></i>Регистрация
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
    
                <!-- Колонка для партнеров -->
                <div class="col-md-4">
                    <h5 class="mb-3">Партнёрам</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a target="_blank" rel="nofollow" href="mailto:partners@gastrofind.com" class="text-decoration-none text-dark">
                                <i class="fas fa-envelope me-2"></i>partners@mingonow.ru
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    
            <!-- Нижняя часть футера -->
            <div class="border-top mt-5 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span class="text-muted mb-2 mb-md-0">© 2025 MinGo. Все права защищены</span>
                    <div>
                        <a href="/policy.pdf" class="text-decoration-none text-dark">
                            <i class="fas fa-file-contract me-2"></i>Политика конфиденциальности
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
    <script src="/libs/bootstrap/bootstrap.bundle.js"></script>
</body>
</html>