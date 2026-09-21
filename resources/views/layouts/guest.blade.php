<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS (via CDN or your build pipeline) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container mt-5">
        <!-- Logo / App Name -->
        <div class="text-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="App Logo" class="img-fluid" style="max-height: 80px;">
            </a>
        </div>

        <!-- Card wrapper for guest content -->
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for components like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @include('layouts.footer')
</body>
</html>
