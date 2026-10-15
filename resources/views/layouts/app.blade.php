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
        @foreach (['css/app.css', 'css/part2.css'] as $cssFile)
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
                <li><a href="{{ route('portfolios.index') }}" class="{{ request()->is('portfolios') ? 'active' : '' }}">Manage Portfolios</a></li>
                <li><a href="{{ route('portfolios.create') }}" class="nav-cta">Create My Portfolio</a></li>
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