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
                    <li style="color:#9aa5cf;font-size:.9rem;">Hi, {{ auth()->user()->name }}</li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:transparent;border:1px solid rgba(129,140,248,.5);color:#e5e9ff;padding:8px 16px;border-radius:999px;font:inherit;font-weight:600;cursor:pointer;">Logout</button>
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