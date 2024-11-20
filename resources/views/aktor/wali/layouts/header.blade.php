<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">
            <div class="logo-topbar">
                <a href="{{ route('wali.pembayaran') }}" class="logo-light">
                    <span class="logo-lg">
                        <h3 class="text-center text-white ms-1 mb-1">SPP ONLINE</h3>
                        <h3 class="text-center text-white ms-1 mb-0">SMKS JAMBI IX LURAH 2</h3>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
                    </span>
                </a>
                <a href="{{ route('wali.pembayaran') }}" class="logo-dark">
                    <span class="logo-lg">
                        <h3 class="text-center text-white ms-1 mb-1">SPP ONLINE</h3>
                        <h3 class="text-center text-white ms-1 mb-0">SMKS JAMBI IX LURAH 2</h3>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
                    </span>
                </a>
            </div>
            <button class="button-toggle-menu">
                <i class="ri-menu-2-fill"></i>
            </button>
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left" title="Theme Mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset('storage/profil/'. Auth::user()->foto) }}" alt="user-image" width="32" class="rounded-circle bg-secondary-subtle">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">{{ ucwords(Auth::user()->nama) }}</h5>
                        <h6 class="my-0 fw-normal">{{ ucwords(Auth::user()->roles[0]->name) }}</h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Selamat Datang !</h6>
                    </div>
                    <a href="{{ route('logout') }}" class="dropdown-item danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                        <span>Keluar</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
