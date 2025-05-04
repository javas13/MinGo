<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MinGo — Поиск ресторанов и баров</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400;500;700&display=swap" rel="stylesheet">
	@vite(['resources/js/app.js', 'resources/libs/bootstrap/bootstrap.bundle.js', 'resources/js/script.js', 'resources/libs/bootstrap/bootstrap.css', 'resources/css/main.css'])
</head>
<body>
    <!-- Шапка сайта -->
	<header>
		<nav class="navbar navbar-expand-lg navbar-light" id="mainNavbar">
			<div class="container">
				<a class="navbar-brand logo" href="/">
					<i class="fas fa-utensils me-2"></i>MinGo
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<div class="ms-auto d-flex align-items-center">
						<a href="mailto:info@gastrofind.com" class="nav-link">
							<i class="fas fa-envelope me-2"></i>
							info@mingonow.ru
						</a>
						<a href="#" class="nav-link heart-link">
							<i class="fas fa-heart me-2 heart-icon" style="color: #ff3366;"></i>
							Избранное
						</a>
                        @auth
                            <div class="ms-auto d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center" 
                                            type="button" 
                                            id="profileDropdown" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <span>Профиль</span>
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
					<a class="footer-logo" href="/">
						<h3 class="logo mb-3">MinGo</h3>
					</a>
                    <div class="social-links">
                        <a href="#" class="text-secondary me-3"><i class="fab fa-telegram-plane fa-lg"></i></a>
                        <a href="#" class="text-secondary me-3"><i class="fab fa-vk fa-lg"></i></a>
                        <a href="#" class="text-secondary me-3"><i class="fab fa-instagram fa-lg"></i></a>
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
                            <a href="mailto:partners@gastrofind.com" class="text-decoration-none text-dark">
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
                        <a href="#" class="text-decoration-none text-dark">
                            <i class="fas fa-file-contract me-2"></i>Политика конфиденциальности
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>