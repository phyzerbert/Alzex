@extends('layouts.auth')
@section('style')
    <style>
        li {
            display: inline-block;
            font-size: 1.2em;
            list-style-type: none;
            text-transform: uppercase;
        }

        li span {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="content d-flex justify-content-center align-items-center">
        <form class="login-form" method="POST" action="{{ route('verify') }}">
            @csrf
            <div class="card mb-0">                
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="icon-mobile2 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="mb-0">{{__('page.verification_phone_number')}}</h5>
                        <span class="d-block text-muted">{{__('page.please_enter_your_verification_code')}}</span>
                    </div>
                    <div class="form-group form-group-feedback form-group-feedback-right">
                        <input id="code" type="number" class="form-control" name="code" value="{{ old('code') }}" placeholder="{{__('page.verification_code')}}" required autofocus>                                
                        <div class="form-control-feedback">
                            <i class="icon-phone2 text-muted"></i>
                        </div>
                        @error('code')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <ul class="p-2 text-center">
                            <li class="px-2"><span id="minutes"></span>Min</li>
                            <li><span id="seconds"></span>Sec</li>
                        </ul>
                    </div>
                    <button type="submit" class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> {{__('page.verify')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
	<script src="{{asset('master/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('master/assets/js/login.js')}}"></script>
    <script>

        let countDown = 300,

        x = setInterval(function() {

            countDown -= 1;            
            document.getElementById('minutes').innerText = pad2(Math.floor(countDown / 60)),
            document.getElementById('seconds').innerText = pad2(Math.floor(countDown % 60));
        
            if (countDown == 0) {
                clearInterval(x);
                window.location.href = "{{route('login')}}";
            }

        }, 1000);

        function pad2(number) {   
            return (number < 10 ? '0' : '') + number        
        }

    </script>
@endsection
