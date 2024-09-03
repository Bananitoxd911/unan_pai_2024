<!DOCTYPE html class="h-full bg-white">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full">
    @include('components.sidebar')
    <div class="p-4 sm:ml-64">
        @yield('contenido')
    </div>

    @yield('scripts')
</body>
</html>