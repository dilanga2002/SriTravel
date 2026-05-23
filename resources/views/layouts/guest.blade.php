<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SriTravel - Register')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full">

            <!-- Header -->
            <div class="text-center mb-10">
                <i class="fas fa-car text-blue-600 text-6xl"></i>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">SriTravel</h2>
            </div>

            <!-- Form Area -->
            <div class="bg-white shadow-2xl rounded-3xl p-8">
                @yield('content')
            </div>

            <p class="text-center text-gray-500 text-sm mt-6">
                © 2025 SriTravel. All rights reserved.
            </p>

        </div>
    </div>

</body>
</html>