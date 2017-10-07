<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MemoryAuth</title>

	<link href="{{ asset('/css/rhcapp.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

</head>
<body>
	<nav class="navbar navbar-default"  
             style="position: fixed; width: 100%; z-index: 1;">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Memory game</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
                                                        <!--<a href="{{ url('/auth/logout') }}">Logout</a>-->
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
        <div style="padding-top: 100px;">
            @yield('content')
        </div>
	<!-- Scripts -->
	<script src="{{ asset('/js/vendor/jquery-2.1.4.js') }}"></script>
	<script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>
        
        <!-- Auth hashtag http://stackoverflow.com/questions/40654710/laravel-login-redirect-loses-the-url-hash -->
        <script type="text/javascript" >
          $( document ).ready(function() {
            $('.urlHash').val(window.location.hash);
          });
        </script>
</body>
</html>
