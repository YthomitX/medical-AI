<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="d-flex">
        <!-- ✅ Sidebar -->
        <nav class="bg-dark text-light p-3 vh-100" style="width: 250px;">
            <h4 class="mb-4">{{ config('app.name', 'Laravel') }}</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link text-light {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('policies.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('policies.*') ? 'active fw-bold' : '' }}">
                        Policies
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('profile.edit') }}" 
                       class="nav-link text-light {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}">
                        Account Settings
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light w-100">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- ✅ Main Content -->
        <div class="flex-grow-1 p-4">
            @isset($header)
                <header class="mb-4">
                    <h2>{{ $header }}</h2>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
