<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MemoryAuth</title>
	<link href="{{ asset('/css/emails.css') }}" rel="stylesheet">
</head>
<body class="emailbody">
    <h1>Hello {{ $name }}!</h1> 
    {{ url('auth/confirm/'.$activation_token) }}
</body>
</html>


