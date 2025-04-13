<nav class="navbar navbar-header navbar-expand navbar-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar mr-1">
                        <img src="{{ url('/') }}/assets/images/avatar/avatar-s-1.png" alt="" srcset="">
                    </div>
                    <div class="d-none d-md-block d-lg-inline-block">Hi, @auth {{ auth()->user()->name }} @endauth</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-item">{{ auth()->user()->role->role }}</div>
                    <div class="dropdown-divider"></div>
                    <form action="{{ url('/') }}/logout" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit"><i data-feather="log-out"></i> Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>