<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">
            <div class="logo-topbar">
                <a href="{{ route('operator.dashboard') }}" class="logo-light">
                    <span class="logo-lg">
                        <h3 class="text-center text-white ms-1 mb-1">SPP ONLINE</h3>
                        <h3 class="text-center text-white ms-1 mb-0">SMKS JAMBI IX LURAH 2</h3>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="small logo">
                    </span>
                </a>
                <a href="{{ route('operator.dashboard') }}" class="logo-dark">
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
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-line fs-22"></i>
                    @php
                        $notifications = App\Services\Notification::getNotifications();
                        $hasUnreadNotification = $notifications->isNotEmpty();
                        $unreadCount = App\Services\Notification::getNotifications()->count();
                    @endphp
                    @if($hasUnreadNotification)
                        <span class="noti-icon-badge"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-16 fw-semibold">Pemberitahuan</h6>
                            </div>
                            <div class="col-auto">
                                @if($hasUnreadNotification)
                                    <a href="javascript: void(0);" class="text-dark text-decoration-underline" onclick="markAllAsRead()">
                                        <small>Hapus Semua</small>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="max-height: 300px;" data-simplebar>
                        @if ($notifications->isEmpty())
                            <a href="javascript:void(0);" class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <small class="noti-item-subtitle text-muted">Tidak ada pemberitahuan pesan baru</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @else
                            @foreach($notifications as $notification)
                                @php
                                    $months = [
                                        "Juli", "Agustus", "September", "Oktober", "November", "Desember",
                                        "Januari", "Februari", "Maret", "April", "Mei", "Juni"
                                    ];

                                    $sppNominal = $notification->nominal ?? 0;

                                    $monthsPaid = $sppNominal > 0 ? intval($notification->jumlah / $sppNominal) : 1;

                                    $currentMonth = $notification->untuk_bulan;
                                    $currentMonthIndex = array_search($currentMonth, $months);

                                    $startMonthIndex = max(0, $currentMonthIndex - $monthsPaid + 1);

                                    if ($monthsPaid > 1) {
                                        $monthRange = $months[$startMonthIndex] . ' - ' . $months[$currentMonthIndex];
                                    } else {
                                        $monthRange = $currentMonth;
                                    }
                                @endphp
                                <a href="javascript:void(0);" class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none" onclick="markAsReadAndNavigate('{{ $notification->notification_id }}')">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2 mb-3">
                                                <div class="notify-icon">
                                                    <img src="{{ asset('storage/profil/' . ($notification->foto_wali ?? 'avatar.png')) }}" alt="avatar" class="rounded-circle" width="50;">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">
                                                    {{ $notification->nama_wali }}
                                                    <small class="fw-normal text-muted float-end ms-1">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted">
                                                    Telah melakukan pembayaran SPP untuk <br> bulan {{ $monthRange }} sebesar Rp.{{ number_format($notification->jumlah) }},-
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </li>
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
                        <h6 class="text-overflow m-0">Welcome !</h6>
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
