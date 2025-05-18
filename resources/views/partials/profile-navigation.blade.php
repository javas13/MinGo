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