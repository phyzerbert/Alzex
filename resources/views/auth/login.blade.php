@extends('layouts.auth')

@section('content')
    <div class="content d-flex justify-content-center align-items-center">
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="mb-0">Login to your account</h5>
                        <span class="d-block text-muted">Enter your credentials below</span>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Username" required autocomplete="name" autofocus>
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">                    
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input-styled-primary" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} data-fouc="">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                    </div>
                    {{-- @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    @endif --}}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
	<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('master/assets/js/login.js')}}"></script>
@endsection
