<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{-- Left navbar links --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
        </li>
    </ul>

    {{-- Right navbar links --}}
    <ul class="navbar-nav ml-auto">
        {{-- User Menu --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i> {{ Auth::user()->name ?? 'Guest' }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-cog mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
