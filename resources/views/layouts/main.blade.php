<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    
    <!-- Title For This Document -->
    <title> Diplom</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss',
            'resources/js/app.js',
    ])
</head>
<body>
    <div id = "app">
        @yield('content')
    </div>
</body>
</html>
