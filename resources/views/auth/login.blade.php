@extends('layouts/guest')

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
style="background-color:white no-repeat center center;">
<div class="p-3">
    <div class="card">
        <div class="container">
            <div class="text-center">
                <img src="{{ asset('assets/images/big/rs.png') }}" style="width: 300px;height: 100px;" alt="wrapkit">
            </div>
            <h2 class="mt-3 text-center">Aplikasi Work Order</h2>
            <p class="text-center">Masukkan alamat email dan kata sandi Anda untuk mengakses aplikasi.</p>
            <form class="mt-4" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="text-dark" for="email">Email</label>
                            <input name="email" class="form-control @error('email') is-invalid @enderror" type="text"
                                placeholder="enter your email" value="{{ old('email') }}" required autofocus>
                            @error('email') 
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="text-dark" for="pwd">Password</label>
                            <input name="password" class="form-control  @error('password') is-invalid @enderror" id="pwd" type="password"
                                placeholder="enter your password">
                            @error('password') 
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="btn btn-block btn-dark">Masuk</button>
                    </div>
                    <div class="col-lg-12 text-center mt-5">
                        <a href="#" class="text-danger">Forgot your password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection