<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AgriPool') — Agricultural Transport Sharing</title>

    {{-- Vite compiles our CSS and JS. This is like importing styles in React. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    {{-- Navigation bar — changes based on role --}}
    @include('layouts.navigation')

    {{-- Flash Messages — shown once after redirect --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Main content area — child views inject content here --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <small>&copy; {{ date('Y') }} AgriPool. All rights reserved.</small>
    </footer>

    @stack('scripts')
</body>
</html>