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

		<title>Sign In</title>
    </head> 

    <body class="login-page">
        <div class="container">
            <div class="row">
                <div class="container-fluid header">    
                    <div class="col-md-1 pull-left">
                        <img class="logo" src="{{ asset('images/pcuLogo.png') }}" alt="pcuLogo" />
                    </div>
                    <div class="col-md-8"><span class="schoolname">Philippine Christian University Dasma Campus </span>
                        <span class="address"><br>Sampaloc 1, City of Dasmariñas</span>
                        <span class="address"><br>Cavite, Philippines</span>
                    </div>
                    {{-- <div class="col-md-3 sis"><span id="sisname">Scheduling System</span></div> --}}
                    <div class = "btn1 pull-right">
                        <a href="login" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-sm-8 col-lg-4 col-md-offset-4 col-sm-offset-2 col-lg-offset-4">
                    <div id="login-form-container">
                        <div class="login-form-header">
                            <h3 class="text-center">TechSCHD</h3>
                        </div>

                        <div class="login-form-body">
                            <div class="row">
                               
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                     <form method="POST" action="{{ URL::to('/login') }}">
                                        {!! csrf_field() !!}
                                        @include('errors.form_errors')

                                        <div class="form-group">
                                            <label>Email</label>
                                                    <input type="username" class="form-control" placeholder="Email" name="Email">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" placeholder="Password" name="password">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="submit" value="SIGN IN" class="btn btn-lg btn-block btn-custom">
                                        </div>

                                        <div class="form-group">
                                            <a href="/request_reset" class="btn btn-lg btn-block btn-primary">Forgot Password?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        @include('partials.scripts')
        @yield('scripts')
    </body>
</html>