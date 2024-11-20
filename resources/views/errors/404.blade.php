@extends('auth.layouts.app')
@section('title', '404 Error | SPP Sekolah')

@section('content')
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <div class="card-header py-4 text-center bg-primary">
                        <a href="{{ url('/') }}">
                            <h3 class="text-center text-white mt-2">SPP ONLINE</h3>
                            <h3 class="text-center text-white">SMK JAMBI IX LURAH 2</h3>
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="text-error">4<i class="ri-emotion-sad-line"></i>4</h1>
                            <h4 class="text-uppercase text-danger mt-3">Halaman Tidak Ditemukan</h4>
                            <p class="text-muted mt-3">
                                Sepertinya Anda mungkin telah salah mengambil langkah. Jangan khawatir... itu
                                terjadi pada yang terbaik dari kita. Berikut adalah
                                sedikit tips yang mungkin bisa membantu Anda kembali ke jalur yang benar.
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-info mt-3">
                                <i class="ri-home-4-line"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
