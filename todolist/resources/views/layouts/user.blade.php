<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Any.do</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/tailwind.css')
    @vite('resources/css/app.css')
</head>

<body>
    <div class="">
        <div class="grid__row">
            <div class="grid__column-sidebar">
                @yield('sidebar')
            </div>
            <div class="grid__column-content">
                content
            </div>
        </div>
    </div>

</body>

</html>
