<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PointSystem')</title>

    <script src="https://kit.fontawesome.com/8a3dad9eb0.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="{{ isset($Sidebar) ? 'no-sidebar' : '' }}">

    @if (!isset($Sidebar))
        @include('components.sidebar')
    @endif


    @yield('content')


    <!--  script para API do Google Maps  -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIX4JNyhVQrRQQCnTMH0sL9zt3LEEGAf8&=initMap" async
        defer></script>
</body>

</html>
