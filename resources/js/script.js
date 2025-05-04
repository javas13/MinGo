document.addEventListener("DOMContentLoaded", function () {

    //Показ и скрытие пароля

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirmPassword');

    function togglePasswordVisibility(icon, field) {
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
        icon.classList.toggle('fa-eye-slash');
        icon.classList.toggle('fa-eye');
    }

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            togglePasswordVisibility(this, password);
        });
    }

    if (toggleConfirmPassword && confirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            togglePasswordVisibility(this, confirmPassword);
        });
    }

   // Обработка выхода из профиля
    $('.logout-js').click(function(e) {
        e.preventDefault();
        if(confirm('Вы уверены, что хотите выйти?')) {
            // Здесь логика выхода
            window.location.href = '/logout';
        }
    });


//Показ индикатора загрузки

function showLoader() {
    document.getElementById('loader').style.display = 'flex';
}

// Функция для скрытия индикатора загрузки
function hideLoader() {
    document.getElementById('loader').style.display = 'none';
}

// Функция для показа уведомления
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


});













