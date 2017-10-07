<!doctype html>
<html lang="en" ng-app="GeolocApp">
    <head>
        <title>Geoloc</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}" />
        <meta charset="utf-8"/>   
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
        <script src="{{ asset('/js/vendor/angular/angular-1.2.18/angular.min.js') }}"></script> 
        <script src="{{ asset('/js/vendor/angular/angular-1.2.18/angular-sanitize.min.js') }}"></script> 
        
        <script src="{{ asset('/js/vendor/angular/angular-1.2.18/angular-route.min.js') }}"></script>
        <script src="{{ asset('/js/vendor/select.js') }}"></script>  
        <script src="{{ asset('/js/geoloc.googlemaps.js') }}"></script>        
        <script src="{{ asset('/js/geoloc.directives.panel.js') }}"></script> 
        <script src="{{ asset('/js/geoloc.js') }}"></script>        
        <script src="{{ asset('/js/geoloc.controllers.panel.js') }}"></script>         
        <script src="{{ asset('/js/geoloc.app.js') }}"></script>         

<!--        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>        
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">        
        <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />        
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">-->

        <link rel="stylesheet" href="{{ asset('/css/rhcapp.css') }}">            
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/select.css') }}">

        <script src="{{ asset('/js/vendor/jquery-2.1.4.js') }}"></script>
        <script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>   

        <script src="{{ asset('/js/vendor/moment-with-locales.js') }}"></script>
        <script src="{{ asset('/js/vendor/bootstrap-datetimepicker.js') }}"></script>  
      

        <!--        Latest compiled and minified CSS 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

 Latest compiled and minified JavaScript 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
 -->
 
    </head>
    <body style="margin: 0px;
                 font-family: roboto, verdana, arial;">                
<!--margin:2px; padding-left: 5px; padding-right: 5px;-->
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
                            <a class="navbar-brand" href=""><span>Geoloc</span></a>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <ul class="nav navbar-nav navbar-right">
                                    @if (Auth::guest())
                                            <li><a href="{{ url('/auth/login') }}">Login</a></li>
                                            <li><a href="{{ url('/auth/register') }}">Register</a></li>
                                    @else
                                            <li class="dropdown">
                                                    <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#/devices">Devices</a></li>
                                                            <li><a href="#/routes">Routes</a></li>
                                                            <li><a href="#/panel">Panel</a></li>
                                                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                                    </ul>
                                            </li>
                                    @endif
                            </ul>
                        </div>
                </div>
        </nav>        
        
        <div ng-view=""
             style="padding-top: 52px;" ng-cloak><div/>
             
    </body>
</html>

