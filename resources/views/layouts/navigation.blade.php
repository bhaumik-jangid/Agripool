<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2d6a4f;">
    <div class="container">

        {{-- Brand Logo --}}
        <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">
            🌾 AgriPool
        </a>

        {{-- Mobile toggle button --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Left side navigation links — change based on role --}}
            <ul class="navbar-nav me-auto">

                @auth
                    {{-- Farmer navigation links --}}
                    @if(Auth::user()->isFarmer())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('farmer.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- Driver navigation links --}}
                    @if(Auth::user()->isDriver())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('driver.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- Admin navigation links --}}
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                                Admin Panel
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            {{-- Right side — user menu or login/register --}}
            <ul class="navbar-nav ms-auto">

                @auth
                    {{-- Role badge --}}
                    <li class="nav-item d-flex align-items-center me-3">
                        <span class="badge bg-warning text-dark text-capitalize">
                            {{ Auth::user()->role }}
                        </span>
                    </li>

                    {{-- User dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#"
                           id="userDropdown" role="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted small">
                                    {{ Auth::user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        🚪 Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>