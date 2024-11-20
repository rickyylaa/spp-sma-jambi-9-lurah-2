@extends('auth.layouts.app')
@section('title', 'SPP ONLINE | SMKS JAMBI IX LURAH 2')

@section('content')
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <div class="card-header py-4 text-center bg-primary">
                        <a href="{{ url('/') }}">
                            <h3 class="text-center text-white mt-2">SPP ONLINE</h3>
                            <h3 class="text-center text-white">SMKS JAMBI IX LURAH 2</h3>
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('prosesLogin') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukan username anda" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password anda">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Ingatkan saya</label>
                                </div>
                            </div>
                            <div class="mb-3 mb-0 text-center">
                                <button type="submit" class="btn btn-primary"> Masuk </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
