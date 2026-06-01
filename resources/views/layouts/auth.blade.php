<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi - Kaukaba')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Konten Form Login / Register -->
    <div class="w-full max-w-md">
        @yield('content')
    </div>

</body>
</html>