<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/blog.css') }}" rel="stylesheet">
    <!--Slick slider-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/slick/slick.css') }}"/>
    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

</head>
<body>
<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                @guest
                    @if (Route::has('login'))
                        <a class="text-muted" href="{{ route('login') }}">Login</a>
                    @endif
                @endguest
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="{{ asset('/') }}">Новости</a>
            </div>

            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="text-muted" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="mx-3">
                        <circle cx="10.5" cy="10.5" r="7.5"></circle>
                        <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                    </svg>
                </a>
                @guest
                    @if (Route::has('register'))
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Sign up</a>
                    @endif
                @else
                    <div class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->getUserName() }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="{{ url('/new-news') }}">Добавить новость</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 1]) }}">Мир</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 2]) }}">Политика</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 3]) }}">Наука</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 4]) }}">Спорт</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 5]) }}">Здоровье</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 6]) }}">Культура</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 7]) }}">Наука</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 8]) }}">Происшествия</a>
            <a class="p-2 text-muted" href="{{ route('category', ['id' => 9]) }}">Экономика</a>
        </nav>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <footer class="blog-footer">
        <p>Авторские права © <?= date('Y') ?> | <a href="#">Alex Kov</a>.</p>
        <p>
            <a href="#">Вернуться наверх</a>
        </p>
    </footer>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- Slick -->
<script type="text/javascript" src="{{ asset('/js/slick/slick.min.js') }}"></script>
<!-- tinymce -->
<script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>

</body>
</html>
