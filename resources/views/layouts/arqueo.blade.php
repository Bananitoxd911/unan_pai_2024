<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://storage.googleapis.com/non-spec-apps/mio-icons/latest/outline.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">


</head>
<body>
    @include('components.sidebar')
    <div class="p-4 sm:ml-64">
        @yield('contenido')
    </div>

    @yield('scripts')
</body>
</html>