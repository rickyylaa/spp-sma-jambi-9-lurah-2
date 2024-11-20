<div class="leftside-menu">
    <a href="{{ route('operator.dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <h4 class="text-center text-white ms-1 mt-2">SPP ONLINE</h4>
            <h4 class="text-center text-white ms-1 mb-2">SMKS JAMBI IX LURAH 2</h4>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
        </span>
    </a>
    <a href="{{ route('operator.dashboard') }}" class="logo logo-dark">
        <span class="logo-lg">
            <h4 class="text-center text-white ms-1 mt-2">SPP ONLINE</h4>
            <h4 class="text-center text-white ms-1 mb-2">SMKS JAMBI IX LURAH 2</h4>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
        </span>
    </a>
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <div class="leftbar-user">
            <a href="javascript:;">
                <img src="{{ asset('storage/profil/'. Auth::user()->foto) }}" alt="user-image" height="42" class="rounded-circle bg-secondary-subtle shadow-sm">
                <span class="leftbar-user-name mt-2">{{ Auth::user()->nama }}</span>
            </a>
        </div>
        <ul class="side-nav">
            <li class="side-nav-title">Navigasi</li>
            <li class="side-nav-item {{ (request()->is('operator/dashboard*')) ? 'menuitem-active' : '' }}">
                <a href="{{ route('operator.dashboard') }}" class="side-nav-link">
                    <i class="ri-home-4-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-title">Data</li>
            <li class="side-nav-item {{ (request()->is('operator/siswa*')) ? 'menuitem-active' : '' }}">
                <a href="{{ route('operator.siswa') }}" class="side-nav-link">
                    <i class="ri-graduation-cap-line"></i>
                    <span> Siswa </span>
                </a>
            </li>
            <li class="side-nav-title">Lainnya</li>
            <li class="side-nav-item {{ (request()->is('operator/pembayaran')) ? 'menuitem-active' : '' }}">
                <a href="{{ route('operator.pembayaran') }}" class="side-nav-link">
                    <i class="ri-bank-card-line"></i>
                    <span> Pembayaran </span>
                </a>
            </li>
            <li class="side-nav-item {{ request()->is('operator/pembayaran/pending*') || request()->is('operator/pembayaran/terima*') || request()->is('operator/pembayaran/tolak*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#sidebarRiwayat" aria-expanded="{{ request()->is('operator/pembayaran/pending*') || request()->is('operator/pembayaran/terima*') || request()->is('operator/pembayaran/tolak*') ? 'ture' : 'false' }}" aria-controls="sidebarRiwayat" class="side-nav-link">
                    <i class="ri-bookmark-line"></i>
                    <span> Riwayat Pembayaran </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('operator/pembayaran/pending*') || request()->is('operator/pembayaran/terima*') || request()->is('operator/pembayaran/tolak*') ? 'show' : '' }}" id="sidebarRiwayat">
                    <ul class="side-nav-second-level">
                        <li class="{{ request()->is('operator/pembayaran/pending*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('operator.pembayaranPending') }}">Pending</a>
                        </li>
                        <li class="{{ request()->is('operator/pembayaran/terima*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('operator.pembayaranTerima') }}">Terima</a>
                        </li>
                        <li class="{{ request()->is('operator/pembayaran/tolak*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('operator.pembayaranTolak') }}">Tolak</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
