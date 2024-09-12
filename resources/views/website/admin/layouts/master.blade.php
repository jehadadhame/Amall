<!DOCTYPE html>
<html lang="en">

<head>
    @stack('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'admin Panel')</title>
</head>

<body>

    @yield('content')
    @stack('js')
</body>

</html>