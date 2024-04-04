@extends('layouts.auth')

@section('content')
<div class="container-fluid justify-content-center">
    <div class="row h-100vh align-items-center login-background">
        <div class="col-md-6 col-sm-12 h-100" id="login-responsive">                
            <div class="card-body pr-10 pl-10 pt-10"> 
                
                <div class="dropdown header-locale" id="frontend-local-login">
                    <a class="icon" data-bs-toggle="dropdown">
                        <span class="fs-12 mr-4"><i class="fa-solid text-black fs-16 mr-2 fa-globe"></i>{{ ucfirst(Config::get('locale')[App::getLocale()]['code']) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                        <div class="local-menu">
                            @foreach (Config::get('locale') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <a href="{{ route('locale', $lang) }}" class="dropdown-item d-flex">
                                        <div class="text-info"><i class="flag flag-{{ $language['flag'] }} mr-3"></i></div>
                                        <div>
                                            <span class="font-weight-normal fs-12">{{ $language['display'] }}</span>
                                        </div>
                                    </a>                                        
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <h3 class="text-center font-weight-bold mb-8">{{__('Welcome to')}} <span class="text-info">{{ config('app.name') }}</span></h3>
                
                <form method="POST" action="{{ route('verification.send') }}" id="verify-email">
                    @csrf                      
                    
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-login alert-success mb-8"> 
                            {{ __('A new verification link has been sent to the email address.') }}
                        </div>
                    @endif

                    <div class="mb-6 fs-14">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you did not receive the email, we will gladly send you another.') }}
                    </div>

                    <div class="form-group mb-0 text-center">                        
                        <button type="submit" class="btn btn-primary mr-2">{{ __('Resend Verification Email') }}</button>                                                                         
                    </div>
                
                </form>
                
                <div class="text-center">
                    <p class="fs-10 text-muted mt-2">or <a class="text-info" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></p> 
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>      
        </div>

        <div class="col-md-6 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
            <div class="login-bg">
                <img src="{{ URL::asset('img/frontend/backgrounds/login.webp') }}" alt="">
            </div>
        </div>
    </div>
</div>
@endsection
