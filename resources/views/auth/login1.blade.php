<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    @include('partials.styles')
    @yield('styles')
                
    </head> 
    <style>
     .logo {
        display: block;
        max-height: 55px;
        width: auto;
        height: auto;
        padding-left: 10px;
        padding-bottom: 9px;
        text-align: center;                                                         
        
    }

        
    </style>

    <title>Sign In | TechSched</title>
        </div>
    <body class="login-page">
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-8"> --}}
                    <div class="login">

                        <div class="col-xs-12 col-md-8 col-sm-8 col-lg-4 col-md-offset-4 col-sm-offset-2 col-lg-offset-4">
                        <div id="login-form-container">
                            <div class="login-form-header" >
                                <span>
                                    <h3>TechSCHD</h3>
                                </span>
                                {{-- <span>
                                    <img class="logo" src="{{ asset('images/schd-logo-white.png') }}" alt="pcuLogo" />
                                </span> --}}
                                
                            </div>  

                            <div class="login-form-body">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <form method="POST" action="{{ URL::to('/login') }}">
                                            {!! csrf_field() !!}
                                            @include('errors.form_errors')

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="username" class="form-control" placeholder="Email"
                                                    name="Email">
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Password"
                                                    name="password">
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" name="submit" value="SIGN IN"
                                                    class="btn btn-lg btn-block btn-custom">
                                            </div>

                                            <div class="form-group">
                                                <a href="/request_reset" class="btn btn-lg btn-block btn-primary">Forgot
                                                    Password?</a>
                                            </div>
                                        </form>
                                        <div class="g-signin2" data-onsuccess="onSignIn"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
