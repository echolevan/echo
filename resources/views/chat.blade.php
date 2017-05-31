<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <style>
        body{
            width: 100%;
            height: 100%;
            overflow-y: auto;
        }

        .container{
            padding: 0;
            margin: 0;
        }

        .navbar-header{
            padding: 0 15px;
        }
    </style>
</head>
<body>
<div id="app">
    <example></example>
</div>

<!-- Scripts -->
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
