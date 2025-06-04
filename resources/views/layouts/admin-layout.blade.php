<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Title не указан')</title>
    @vite(['resources/js/app.js', 'resources/libs/bootstrap/bootstrap.bundle.js', 'resources/libs/bootstrap/bootstrap.css', 'resources/libs/fontawesome/css/all.css', 'resources/css/admin.css', 'resources/js/admin.js'])
    <script src="/libs/tinymce/tinymce.min.js"></script>
    <link rel="stylesheet" href="/libs/swal/dist/sweetalert2.min.css">
    <script src="/libs/swal/dist/sweetalert2.min.js"></script>
</head>
<body>
<div id="bfwrap">
    <div id="adminmenumain">
        <div id="adminmenuback"></div>
        <div id="adminmenuwrap">
            <ul id="adminmenu">
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="/admin/dashboard" class="bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-regular fa-window-maximize mx-2"></i></i>Дашбоард</div>
                    </a>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.places')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Заведения</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.places')}}">Все заведения</a>
                        </li>
                        <li>
                            <a href="{{route('admin.places.add.store')}}">Добавить заведение</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.category.list')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Категории</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.category.list')}}">Все категории</a>
                        </li>
                        <li>
                            <a href="{{route('admin.category.add')}}">Добавить категорию</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.kitchens.list')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Кухни</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.kitchens.list')}}">Все кухни</a>
                        </li>
                        <li>
                            <a href="{{route('admin.kitchens.add')}}">Добавить кухню</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.cities')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Города</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.cities')}}">Все города</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cities.add')}}">Добавить город</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.districts')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Округа</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.districts')}}">Все округа</a>
                        </li>
                        <li>
                            <a href="{{route('admin.districts.add')}}">Добавить округ</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.adverts')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Реклама</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.adverts')}}">Список рекламных компаний</a>
                        </li>
                        <li>
                            <a href="{{route('admin.adverts.add')}}">Добавить рекламную компанию</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.banners')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Банеры</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.banners')}}">Все банеры</a>
                        </li>
                        <li>
                            <a href="{{route('admin.banners.add.store')}}">Добавить банер</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.news')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Новости</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.news')}}">Все новости</a>
                        </li>
                        <li>
                            <a href="{{route('admin.news.add')}}">Добавить новость</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.promotion.events')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>События</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.promotion.events')}}">Все события</a>
                        </li>
                        <li>
                            <a href="{{route('admin.promotion.events.add.store')}}">Добавить событие</a>
                        </li>
                    </ul>
                </li> --}}
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.faqs')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>FAQ</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.faqs')}}">Все FAQ</a>
                        </li>
                        <li>
                            <a href="{{route('admin.faqs.add')}}">Добавить FAQ</a>
                        </li>
                    </ul>
                </li>
                <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.staff')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Персонал</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.staff')}}">Список персонала</a>
                        </li>
                        <li>
                            <a href="{{route('admin.staff.add')}}">Добавить персонал</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="bf-first-item js-menu bf-first-item-li bf-has-submenu bf-not-current-submenu menu-top menu-top-first">
                    <a href="{{route('admin.newsletter.subscribers.list')}}" class="bf-has-submenu bf-first-item-link bf-not-current-submenu menu-top">
                        <div class="bf-menu-name"><i class="fa-solid fa-image mx-2"></i>Рассылка</div>
                    </a>
                    <ul class="bf-submenu bf-submenu-wrap">
                        <li>
                            <a href="{{route('admin.newsletter.add')}}">Сделать рассылку</a>
                        </li>
                        <li>
                            <a href="{{route('admin.newsletter.subscribers.list')}}">Список подписчиков</a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
    <div id="bf-content">
        <div class="bf-admin-bar">
            <ul>
                <li>
                    <a>
                        <div class="header_burger">
                            <div class="burger_one"></div>
                            <div class="burger_one"></div>
                            <div class="burger_one"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="bf-logo" href="#">
                        <img src="/img/logo-big-fog-white.png" alt="">
                    </a>
                </li>
                <li>
                    <a href="/"><i class="fa-solid fa-home mx-1"></i>MinGO</a>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-plus mx-1"></i>Добавить</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{ route('admin.logout') }}"><i class="fa-solid fa-right-from-bracket mx-1"></i>Выйти</a>
                </li>
            </ul>
        </div>
        <div class="bf-admin-body">
            @yield('content')
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></>
</body>
</html>
