<div class="leftside-menu">
    <a href="{{ route('wali.pembayaran') }}" class="logo logo-light">
        <span class="logo-lg">
            <h4 class="text-center text-white ms-1 mt-2">SPP ONLINE</h4>
            <h4 class="text-center text-white ms-1 mb-2">SMKS JAMBI IX LURAH 2</h4>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
        </span>
    </a>
    <a href="{{ route('wali.pembayaran') }}" class="logo logo-dark">
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
            <li class="side-nav-title">Data</li>
            <li class="side-nav-item {{ (request()->is('wali/pembayaran')) ? 'menuitem-active' : '' }}">
                <a href="{{ route('wali.pembayaran') }}" class="side-nav-link">
                    <i class="ri-bank-card-line"></i>
                    <span> Pembayaran </span>
                </a>
            </li>
            <li class="side-nav-item {{ (request()->is('wali/riwayat/pembayaran')) ? 'menuitem-active' : '' }}">
                <a href="{{ route('wali.riwayat') }}" class="side-nav-link">
                    <i class="ri-bookmark-line"></i>
                    <span> Riwayat Pembayaran </span>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
