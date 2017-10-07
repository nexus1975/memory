<!doctype html>
<html lang="en" ng-app="MemoryApp">
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <title>Memory game</title>
  <link rel="stylesheet" href="{{ asset('/css/loading-bar.css') }}" type='text/css' media='all'/> 
  <link rel="stylesheet" href="{{ asset('/css/rhcapp.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}"/>  
  <link rel="stylesheet" href="{{ asset('/css/flip.css') }}"/>
</head>
<body id="body">
    <div id="loading-bar-container"></div>
    
    <!-- nav -->
    <nav class="navbar navbar-default" 
         style="position: fixed; 
                width: 100%; 
                z-index: 1;"
         ng-controller="NavCtrl">
            <div class="container-fluid">
                    <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle Navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                            </button>
                        <a class="navbar-brand" href="#"><span nowrap>Memory game</span></a>                                
                            <!--<a class="navbar-brand" href="#"><input ng-model="countdown"/></a>-->
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <!--
                        <ul class="nav navbar-nav">
                                <li><a href="{{ url('/') }}">Home</a></li>
                        </ul>
                        -->

                        <ul class="nav navbar-nav navbar-right">
                                @if (Auth::guest())
                                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                                        <li><a href="{{ url('/auth/register') }}">Register</a></li>
                                @else
                                        <li class="dropdown">
                                                <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                                <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                                </ul>
                                        </li>
                                @endif
                        </ul>
                    </div>
            </div>
    </nav>

    <!-- ng-view -->
    <div ng-view style="padding-top: 50px;"></div>
        
</body>
<script src="{{ asset('/js/vendor/angular/angular-1.2.16/angular.min.js')}}"></script>
<script src="{{ asset('/js/vendor/angular/angular-1.2.16/angular-route.min.js')}}"></script>
<script src="{{ asset('/js/vendor/angular/angular-1.2.16/angular-animate.min.js')}}"></script>  
<script src="{{ asset('/js/vendor/loading-bar.js')}}"></script>

<script src="{{ asset('/js/services.js')}}"></script>
<script src="{{ asset('/js/controllers.js')}}"></script>
<script src="{{ asset('/js/filters.js')}}"></script>
<script src="{{ asset('/js/directives.js')}}"></script>
<script src="{{ asset('/js/app.js')}}"></script>

<script src="{{ asset('/js/vendor/jquery-2.1.4.js') }}"></script>
<script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>

</html>
