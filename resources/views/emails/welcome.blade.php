<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Welcome to Memory Game</title>
            <link href="{{ asset('/css/rhcapp.css') }}" rel="stylesheet">        
            <link href="{{ asset('/css/emails.css') }}" rel="stylesheet"> 
    </head>
    <body class="emailbody">
        <p>
            <b>Hi {{ $name }}!</b>
        </p>
        <p>
            Please confirm your e-mail by clicking on this link: {{ url('confirm/'.$token) }}
        </p>
        {{ $name }}
    </body>
</html>
