@extends('layouts.main')

@section('title', 'Home')

@section('content')
    {{-- <div class="alert alert-info" role="alert">Вам отправлено письмо на почту для подтверждения регистрации.</div>
    <div>Не получили письма?</div>
    <form action="{{route('verification.send')}}" method="post">
        @csrf
        <button type="submit" class="btn btn-link ps-0">Отправить ещё раз</button>
    </form> --}}

    <div class="container">
        <div class="auth-container">
            <i class="fas fa-envelope-open email-icon"></i>
            <h2 class="mb-3">Подтвердите ваш email</h2>
            <p class="text-muted mb-4">
                Мы отправили письмо с подтверждением на ваш email.<br>
                Пожалуйста, проверьте вашу почту и перейдите по ссылке в письме.
            </p>

            <div class="mt-5">
                <p class="text-muted">Не получили письма?</p>
                <a class="resend-btn" id="resendButton">
                    <i class="fas fa-redo-alt me-2"></i>Отправить ещё раз
                </a>
                <div class="timer-text" id="timerText">
                    Следующее письмо можно отправить через <span id="countdown">60</span> сек
                </div>
            </div>

            <p class="support-text">
                Если у вас возникли проблемы, свяжитесь с нами:<br>
                <a href="mailto:support@gastrofind.com" class="contact-link">
                    support@gastrofind.com
                </a>
            </p>
        </div>
    </div>

    <script type="module">
         //ТАЙМЕР НА СТРАНИЦЕ ПОДТВЕРЖЕНИЯ EMAIL

    const resendButton = document.getElementById('resendButton');
    const timerText = document.getElementById('timerText');
    const countdownElement = document.getElementById('countdown');
    let countdown = 0;
    let timer;
    const remaining = {{ $remaining ?? '0' }};
    if (remaining > 0) {
        startTimer(remaining);
    }

    resendButton.addEventListener('click', function(e) {
        if(resendButton.classList.contains('disabled') == false){
            showLoader();
        $.ajax({
            type: 'Post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/email/verification-notification',
        }).done(function (data) {
            setTimeout(function() {
                hideLoader(); // Скрываем индикатор после завершения
                if (resendButton.classList.contains('disabled')) return;
        
                // Блокируем кнопку
                resendButton.classList.add('disabled');
                timerText.style.display = 'block';
                
                // Устанавливаем таймер
                countdown = 60;
                updateCountdown();
                
                // Запускаем таймер
                timer = setInterval(function() {
                    countdown--;
                    updateCountdown();
                    
                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendButton.classList.remove('disabled');
                        timerText.style.display = 'none';
                    }
                }, 1000);

                showNotification(
                    'success',
                    'Успешно!',
                    'Письмо было отправлено на вашу почту',
                    5000
                );
            }, 1000); // Задержка
        }).fail(function () {
            hideLoader(); 
            showNotification(
                'error',
                'Ошибка!',
                'Неизвестная ошибка',
                5000
            );
        });
        e.preventDefault();
        }
        
    });

    function updateCountdown() {
        countdownElement.textContent = countdown;
    }

    function startTimer(remaining) {
                if (resendButton.classList.contains('disabled')) return;
        
                // Блокируем кнопку
                resendButton.classList.add('disabled');
                timerText.style.display = 'block';
                
                // Устанавливаем таймер
                countdown = remaining;
                updateCountdown();
                
                // Запускаем таймер
                timer = setInterval(function() {
                    countdown--;
                    updateCountdown();
                    
                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendButton.classList.remove('disabled');
                        timerText.style.display = 'none';
                    }
                }, 1000);

    }

    function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }

    // Функция для скрытия индикатора загрузки
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }

    function showNotification(type, title, message, duration = 5000) {
    const container = document.getElementById('notificationContainer');
    
    // Создаем элемент уведомления
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    // Иконка в зависимости от типа
    const icon = type === 'success' 
        ? '<i class="fas fa-check-circle notification-icon"></i>'
        : '<i class="fas fa-exclamation-circle notification-icon"></i>';
    
    // HTML уведомления
    notification.innerHTML = `
        ${icon}
        <div class="notification-content">
            <div class="notification-title">${title}</div>
            <div class="notification-message">${message}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Добавляем в контейнер
    container.appendChild(notification);
    
    // Запускаем анимацию появления
    setTimeout(() => notification.classList.add('show'), 10);
    
    // Автоматическое закрытие
    if (duration > 0) {
        setTimeout(() => {
            notification.classList.add('hide');
            notification.addEventListener('animationend', () => {
                notification.remove();
            });
        }, duration);
    }
}
    </script>
@endsection
