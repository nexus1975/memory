<!doctype html>
<html>
	<head>
		<title>Memory game</title>
                <meta charset="utf-8">   
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
                <link rel="stylesheet" href="{{ asset('/css/rhcapp.css') }}">
                <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
	</head>
	<body id="body">
            <div style="text-align: center; margin-top: 40px;">
                
                
                <img src="{{ asset('/images/Sweden_road_sign_A19-7.svg.png') }}" 
                     alt="Welcome"
                     style="margin-top: 10px; margin-bottom: 0px;"/>
                
                <h1>Memory game</h1>
                <br><br>
                                   <!--<div class="quote">{{ Inspiring::quote() }}</div>-->
                <div style="font-size: 200%;">
                    <button class="btn-primary btn-lg" 
                            onclick="window.location='auth/login'"><span nowrap>Sign in</span></button>
                    <br>
                    <font size="-1">or</font>
                    <br>
                    <a href="auth/register">sign up</a>
                      
                </div>
                
                <div style="height: 20px; 
    position: fixed; 
    bottom:0%;
    width:100%; 
    background-color: white; 
    vertical-align:middle;
    opacity: 1;">&copy;2016</div>                                                    
            </div>
            
	<script src="{{ asset('/js/vendor/jquery-2.1.4.js') }}"></script>
	<script src="{{ asset('/js/vendor/bootstrap.min.js') }}"></script>

	</body>
</html>
