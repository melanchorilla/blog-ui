<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/blog.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Blog Laravel UI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link {{ request()->is('posts') || request()->is('/')  ? 'active' : ''}}" href="{{ route('posts') }}">Posts</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : ''}}" href="{{ route('about') }}">About</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a class="nav-link {{ request()->is('dashboard') ? 'active' : ''}}" href="{{ route('dashboard') }}">Dashboard</a></li>
                            @else
                                @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link {{ request()->is('register') ? 'active' : ''}}" href="{{ route('register') }}">Register</a></li>
                                @endif
                                    <li class="nav-item"><a class="nav-link {{ request()->is('login') ? 'active' : ''}}" href="{{ route('login') }}">Login</a></li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        

        <!-- Page content-->
       @yield('content')

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Blog UI 2022</p></div>
        </footer>
        <!-- Core JS-->
        <script src="/js/app.js"></script>
        <!-- Core theme JS-->
        <script src="/js/blog.js"></script>
    </body>
</html>
