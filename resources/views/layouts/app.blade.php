<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic Page Title -->
    <title>@yield('title', 'SriTravel - Premium Vehicle Rentals')</title>
    
    <!-- Favicon (Same on All Pages) -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon-32x32.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    @include('layouts.navigation')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>