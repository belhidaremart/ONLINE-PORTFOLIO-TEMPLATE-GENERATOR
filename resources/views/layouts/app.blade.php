<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portfolio Template Generator')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        @foreach (['css/app.css', 'css/part2.css', 'css/spacing.css'] as $cssFile)
            @if (file_exists(public_path($cssFile)))
                {!! file_get_contents(public_path($cssFile)) !!}
            @endif
        @endforeach
    </style>
    @stack('styles')

    <style>
        /* Menu: clear spacing and one line per item */
        .navbar .nav-links li {
            margin: 0 8px;
            white-space: nowrap;
            font-size: .92rem;
            line-height: 1.2;
        }
        .navbar .nav-links li:last-child {
            margin-left: 20px;
        }
        .navbar .nav-links a {
            padding: 10px 18px;
            border-radius: 999px;
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            text-decoration: none;
            transition: background .2s, color .2s, filter .2s;
        }
        .navbar .nav-links a:hover {
            background: rgba(129, 140, 248, .18);
        }
        .navbar .nav-links a.active {
            background: rgba(129, 140, 248, .2);
            color: #67e8f9;
        }
        .navbar .nav-links a.nav-cta {
            padding: 11px 22px;
            background: linear-gradient(135deg, #06b6d4, #8b5cf6);
            color: #fff;
        }
        .navbar .nav-links a.nav-cta:hover {
            filter: brightness(1.1);
        }
        .navbar .nav-links .nav-user {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #9aa5cf;
            font-size: .9rem;
        }
        .navbar .nav-links .nav-logout {
            padding: 9px 20px;
            background: transparent;
            border: 1px solid rgba(129, 140, 248, .5);
            border-radius: 999px;
            color: #e5e9ff;
            font: inherit;
            font-size: .9rem;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            cursor: pointer;
            transition: background .2s;
        }
        .navbar .nav-links .nav-logout:hover {
            background: rgba(129, 140, 248, .18);
        }
        .navbar .nav-links form {
            margin: 0;
        }
        @media (max-width: 860px) {
            .navbar .nav-links li,
            .navbar .nav-links li:last-child {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="container navbar-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-icon">P</span>
                <span>Portfolio Template Generator</span>
            </a>

            <input type="checkbox" id="navCheck" class="nav-check">
            <label for="navCheck" class="nav-toggle" aria-label="Menu">&#9776;</label>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                @auth
                    <li><a href="{{ route('portfolios.index') }}" class="{{ request()->is('portfolios') ? 'active' : '' }}">Manage Portfolios</a></li>
                    <li><a href="{{ route('portfolios.create') }}" class="nav-cta">Create My Portfolio</a></li>
                    <li class="nav-user">Hi, {{ auth()->user()->name }}</li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-logout">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Log In</a></li>
                    <li><a href="{{ route('register') }}" class="nav-cta">Register</a></li>
                @endauth
            </ul>
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="container">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="container">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Portfolio Template Generator. College Project.
        </div>
    </footer>

</body>
</html>
