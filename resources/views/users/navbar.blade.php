<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link scrollto {{ Request::is('users/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Home</a></li>
        <li><a class="nav-link scrollto {{ Request::is('users/proses') ? 'active' : '' }}" href="{{ route('proses') }}">Daftar KRK Proses</a></li>
        <li class="dropdown"><a href="#">{{ Auth::user()->email }}</a>
            <ul>
                <li><a class="dropdown-item" href="{{ route('user-logout') }}"
                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('user-logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </li>
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->