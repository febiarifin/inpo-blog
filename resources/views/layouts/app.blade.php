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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--SweetAlert 2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Trix editor-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/trix.css')}}">
    <script type="text/javascript" src="{{asset('js/trix.js')}}"></script>

    <!-- Bootstrap Tags Input CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet" />
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #2196f3;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <div id="app" class="wrapper">
        @auth
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="/home">
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

                    @if (Auth::user()->role == 1)
                    <li class="sidebar-item {{ $buttonCategory }}">
                        <a class="sidebar-link" href="{{ route('categories') }}">
                            <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Manajemen
                                Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ $buttonUser }}">
                        <a class="sidebar-link" href="{{ route('users') }}">
                            <i class="align-middle" data-feather="users"></i> <span class="align-middle">Manajemen
                                User</span>
                        </a>
                    </li>
                    @endif

                    <li class="sidebar-item">

                        <a class="sidebar-link" href="{{ url('/') }}">
                            <i class="align-middle" data-feather="eye"></i> <span class="align-middle">Lihat Blog</span>
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

                            <a class="nav-link d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark">
                                    {{ Auth::user()->name}}
                                    <i class="fa-solid fa-caret-down"></i>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="">
                                    <i class=" fa-solid fa-user"></i> Profile
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
                                <strong>{{ config('app.name', 'Laravel') }}</strong></a> &copy; 2022
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
    {{-- Bootstrap Tags Input CDN --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
</body>

</html>