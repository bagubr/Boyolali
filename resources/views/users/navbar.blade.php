<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link p-2 m-2 scrollto {{ Request::is('users/proses') ? 'active' : '' }}" href="{{ route('proses') }}">Daftar Permohonan</a></li>
        <li class="dropdown"> <a class="text-center p-2 m-2" style="background: #47b2e4;color: #fff; border-radius: 50px;" href="#">{{ Auth::user()->email }}</a>
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

<style>
    .navbar .dropdown:hover>a {
        color: #fff;background: #47b2e4; border-radius: 50px; margin: 30; padding: 20;
    }
</style>