<!DOCTYPE html class="h-full bg-white">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Integración de Jquery y SweetAlert dentro del proyecto desde CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body class="h-full">
    @include('components.sidebar')
    <div class="p-4 sm:ml-64">
        @yield('contenido')
    </div>

    @yield('scripts')
</body>
</html>