<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Any.do</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @vite('resources/css/tailwind.css')
    @vite('resources/css/app.css')
</head>

<body>
    @yield('page')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.js"></script>
</body>
</html>