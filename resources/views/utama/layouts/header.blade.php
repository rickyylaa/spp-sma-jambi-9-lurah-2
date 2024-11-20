<header class="header-area section">
    <div class="header-top section">
        <div class="container">
            <div class="row">
                <div class="header-top-left text-start col-7">
                    <p>Ada Pertanyaan? 0812 3456 7890</p>
                </div>
                <div class="header-top-right text-end col-5">
                    <ul>
                        <li>
                            <a href="{{ route('login') }}">Masuk</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom bg-white sticker section sticker">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="header-logo float-start">
                        <a href="{{ route('utama.index') }}">
                            <img src="{{ asset('dist/images/logo/logo-2.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="header-buttons float-end"></div>
                    <div class="main-menu float-end hidden-xs">
                        <nav>
                            <ul>
                                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                                    <a href="{{ route('utama.index') }}">Beranda</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div>
</header>
