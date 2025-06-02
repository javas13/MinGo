
document.addEventListener("DOMContentLoaded", function () {

    $('.copy-btn-js').click(function(e){
       let copyText = this.dataset.copyText;
        const textarea = document.createElement('textarea');
        textarea.value = copyText;
        document.body.appendChild(textarea);
        
        // Выделяем и копируем текст
        textarea.select();
        document.execCommand('copy');
        
        // Удаляем временный элемент
        document.body.removeChild(textarea);
        showNotification('success', 'Успешно!', 'Ссылка успешно скопирована!');
    });

    $('.window-open-trigger-js').click(function(e){
        let windowId = this.dataset.forWindowId;
        let dataText = '[data-window-id="' + windowId + '"]';
        let windowToOpen = $(dataText);
        windowToOpen.addClass('active');
    });

    $('.filters-window__wrapper').click(function(e) {
        if ($(e.target).hasClass('filters-window__wrapper')) {
            $(this).removeClass('active');
        }
    });
    
    // Закрытие при клике на кнопку закрытия
    $('.filters-window__close-btn-js').click(function() {
        let windowId = this.dataset.forWindowId;
        let dataText = '[data-window-id="' + windowId + '"]';
        let windowToOpen = $(dataText);
        windowToOpen.removeClass('active');
    });
    


    let headerBurger = document.querySelector('.header__burger-js');
    if (headerBurger != null) {
        document.querySelector('.header__burger-js').addEventListener('click', function () {

            if (document.querySelector('.header__mobile-menu-js').classList.contains('active')) {
                // document.getElementsByTagName('body')[0].style.cssText = 'overflow-y: auto;';
                document.querySelector('.header__mobile-menu-js').classList.remove('active');
                document.querySelector('.header__burger-js').classList.remove('active');
    
            }
            else {
                // document.getElementsByTagName('body')[0].style.cssText = 'overflow-y: hidden;';
                document.querySelector('.header__mobile-menu-js').classList.add('active');
                document.querySelector('.header__burger-js').classList.add('active');
            }

        })
    }

    let headerCloseBtn = document.querySelector('.header__mobile-close-btn-js');
    if(headerCloseBtn != null){
        headerCloseBtn.addEventListener('click', function () {
            document.querySelector('.header__mobile-menu-js').classList.remove('active');
            document.querySelector('.header__burger-js').classList.remove('active');          

        })
    }

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













