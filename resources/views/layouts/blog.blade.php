<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- icons -->
    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .badge-category {
            background-color: black;
            position: relative;
            top: -250px;
            left: -12px;
            padding: 1px 5px 1px 5px;
            border-radius: 2px;
            opacity: 60%;
            margin-right: 5px;
        }

        .badge-category>a {
            text-decoration: none;
            color: white;
        }

        .link-post {
            text-decoration: none;
            color: #474747;
        }

        @media screen and (min-width: 600px) {
            .container-show-post {
                padding: 100px 150px 100px 150px;
            }
        }

        @media screen and (max-width: 600px) {
            .container-show-post {
                padding: 20px;
            }
        }
    </style>

</head>

<body>
    @include('sweetalert::alert')


    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm ">
        <div class="container">
            <a class="navbar-brand fs-3" href="/">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @foreach ($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link fs-5 @if($category->slug == $menuActive) active @endif" aria-current="page"
                            href="{{ url('category/'.$category->slug)}}">{{$category->name}}</a>
                    </li>
                    @endforeach

                </ul>

                <span class="navbar-text">
                    @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 py-1 sm:block">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                        @auth
                        <a href="{{ url('/home') }}" class="btn btn-light">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-light">Login</a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                        @endif
                        @endauth

                    </div>
                    @endif
                </span>


            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">

        @yield('content')

    </div>

    <div class="container text-center p-3">
        <p>{{ config('app.name', 'Laravel') }} &copy 2022 </p>
        <a href="https://github.com/febiarifin/inpo-blog">Source code on Github
            <i class="fa-brands fa-github"></i></a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('search') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan kata kunci"
                                aria-label="Masukkan kata kunci" aria-describedby="button-addon2" name="keyword">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('js/app.js')}}"></script>

</body>

</html>