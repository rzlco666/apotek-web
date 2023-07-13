@extends('layouts.auth.master')

@section('title')
    Sign In
@endsection

@section('auth_css')

@endsection

@section('auth_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/3.jpg') }}" alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <div>
                        <div><a class="logo" href="#"><img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo2.png') }}" alt="looginpage"></a></div>
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h4 class="text-center">Masuk ke akun</h4>
                                <p class="text-center">Masukkan email dan kata sandi Anda untuk masuk</p>
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Alamat Email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Kata Sandi') }}</label>
                                    <div class="form-input position-relative">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Ingat Saya') }}
                                        </label>
                                    </div><a class="link" href="{{ route('password.request') }}">{{ __('Lupa Kata Sandi Anda?') }}</a>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary btn-block w-100">
                                            {{ __('Masuk') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="login-social-title">
                                    <h6>Atau masuk dengan                 </h6>
                                </div>
                                <div class="form-group">
                                    <ul class="login-social">
                                        <li><a href="https://www.linkedin.com" target="_blank"><i data-feather="linkedin"></i></a></li>
                                        <li><a href="https://twitter.com" target="_blank"><i data-feather="twitter"></i></a></li>
                                        <li><a href="https://www.facebook.com" target="_blank"><i data-feather="facebook"></i></a></li>
                                        <li><a href="https://www.instagram.com" target="_blank"><i data-feather="instagram"></i></a></li>
                                    </ul>
                                </div>
                                <p class="mt-4 mb-0 text-center">Belum punya akun?<a class="ms-2" href="{{ route('register') }}">Buat Akun</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('auth_script')

@endsection
