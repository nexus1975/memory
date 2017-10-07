<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MemoryGame</title>
	<link href="{{ asset('/css/emails.css') }}" rel="stylesheet">
</head>
<body class="emailbody">
    <h1>Hello {{ $name }}</h1> 
    <h2>You've just started memory game <a href="{{ url('home#/game/'.$id.'/play') }}">{{ $game }}</a>.</h2> 
    <p>{{ date("F j, Y, g:i:s a") }}</p>
</body>
</html>


