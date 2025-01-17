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
                
                <form method="POST" action="{{ route('login.2fa.store') }}">
                    @csrf                                       

                    <h3 class="text-center font-weight-bold mb-8"><i class="fa-solid fa-shield-check fs-24 text-success mr-2"></i>{{ __('One Time Password') }}</h3>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-login alert-success"> 
                            <strong><i class="fa fa-check-circle"></i> {{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-login alert-danger">
                            <strong><i class="fa fa-exclamation-triangle"></i> {{ $message }}</strong>
                        </div>
                    @endif
                

                    <div class="input-box mb-4">            
                        <label for="email" class="fs-12 text-md-right">{{ __('Enter the code displayed in your Google Authenticator app') }}</label>                 
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" autocomplete="off" maxlength="6" required>
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror                            
                    </div>


                    <div class="form-group mb-0 text-center">                        
                        <button type="submit" class="btn btn-primary mr-2 pl-5 pr-5">{{ __('Continue') }}</button>                              
                    </div>
                </form>
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

@section('js')
    <!-- Tippy css -->
    <script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
    <script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
    <script>
        tippy('[data-tippy-content]', {
                animation: 'scale-extreme',
                theme: 'material',
            });
    </script>
    @if (config('services.google.recaptcha.enable') == 'on')
        <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif
    
@endsection