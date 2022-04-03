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

    <!-- icons -->
    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <!--SweetAlert 2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    @include('sweetalert::alert')

    <div id="app" class="wrapper">
        @auth
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle"> {{ config('app.name', 'Laravel') }}</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Navigasi
                    </li>

                    <li class="sidebar-item {{ $buttonDashboard }}">
                        <a class="sidebar-link" href="{{route('home')}}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ $buttonPosts }}">
                        <a class="sidebar-link" href="{{route('posts')}}">
                            <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Manajemen
                                Artikel</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ $buttonCategory }}">
                        <a class="sidebar-link" href="">
                            <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Manajemen
                                Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ $buttonSetting }}">
                        <a class="sidebar-link" href="">
                            <i class="align-middle" data-feather="settings"></i> <span
                                class="align-middle">Pengaturan</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/">
                            <i class="align-middle" data-feather="eye"></i> <span class="align-middle">Lihat
                                Blog</span>
                        </a>
                    </li>

                </ul>

            </div>
        </nav>
        @endauth

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                @auth
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                @endauth

                @guest
                @if (Route::has('login'))
                <a class="sidebar-brand text-secondary" href="/">
                    <span class="align-middle"> {{ config('app.name', 'Laravel') }}</span>
                </a>
                @endif
                @endguest

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">

                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                <span class="text-dark">{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="pages-profile.html">
                                    <i class="align-middle me-1" data-feather="user"></i> Profile
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="align-middle me-1" data-feather="log-out"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                    </ul>
                </div>
            </nav>

            @yield('content')

            @auth
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <strong>Inpo Blog</strong></a> &copy; 2022
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            @endauth
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
</body>

</html>