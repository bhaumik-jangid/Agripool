<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AgriPool') — Agricultural Transport Sharing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/premium.css'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body style="background: linear-gradient(135deg, #2d6a4f 0%, #52b788 100%); min-height: 100vh;">

    {{-- Centered card for auth forms --}}
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5">

                {{-- Logo at top --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <h2 class="text-white fw-bold">🌾 AgriPool</h2>
                        <p class="text-white-50">Agricultural Transport Sharing Platform</p>
                    </a>
                </div>

                {{-- Form card --}}
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>