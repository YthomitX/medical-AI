<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coast Guard Medical AI System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1; /* pushes footer to bottom */
        }
        footer {
            background-color: #212529;
            color: #fff;
            padding: 1rem;
        }
        footer a {
            color: #adb5bd;
            margin: 0 10px;
            text-decoration: none;
        }
        footer a:hover {
            color: #fff;
        }
        h1, h2 {
            font-size: 2rem; /* keep welcome text readable */
        }
    </style>
</head>
<body>
    <!-- ✅ Use navigation.blade instead of static header -->
    @include('layouts.navigation')

    <!-- ✅ Page Content -->
    <main class="container mb-5">
        <!-- ✅ Flash messages -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
         <!-- ✅ Page Content -->
        @yield('content')
    </main>

    <!-- ✅ Footer fixed at bottom -->
    <footer class="text-center mt-auto">
        <p class="mb-1">© 2026 Coast Guard Medical AI System. All rights reserved.</p>
        <div>
            <a href="{{ route('policies.index') }}">Policies</a> |
            <a href="#">Account</a> |
            <a href="#">Contact</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




