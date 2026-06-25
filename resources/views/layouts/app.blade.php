<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accounting App</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Accounting App
                </a>
                <div class="navbar-nav">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">
                        Category
                    </a>
                    <a class="nav-link {{ request()->routeIs('coas.*') ? 'active' : '' }}"
                        href="{{ route('coas.index') }}">
                        COA
                    </a>
                    <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                    href="{{ route('transactions.index') }}">
                        Transaction
                    </a>
                    <a class="nav-link {{ request()->routeIs('profit-loss.*') ? 'active' : '' }}"
                        href="{{ route('profit-loss.index') }}">
                        Profit Loss
                    </a>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>

        @yield('scripts')
    </body>
</html>