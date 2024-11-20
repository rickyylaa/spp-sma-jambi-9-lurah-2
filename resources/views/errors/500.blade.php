@extends('auth.layouts.app')
@section('title', '505 Error | SPP Sekolah')

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
                            <img src="{{ asset('assets/images/svg/startman.svg') }}" height="120" alt="File not found Image">
                            <h1 class="text-error mt-4">500</h1>
                            <h4 class="text-uppercase text-danger mt-3">Kesalahan Server Internal</h4>
                            <p class="text-muted mt-3">
                                Mengapa tidak mencoba menyegarkan halaman Anda? atau Anda dapat menghubungi
                                <a href="javascript:;" class="text-muted"><b>Kami</b></a>
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-info mt-3">
                                <i class="ri-home-4-line me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
