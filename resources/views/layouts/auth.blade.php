<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Autentikasi - BMB Travel')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

    <div class="absolute top-0 left-0 w-72 h-72 bg-teal-900/5 rounded-full blur-3xl pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-amber-500/3 rounded-full blur-3xl pointer-events-none translate-x-1/3 translate-y-1/3"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in my-auto">
        @yield('content')
    </div>

</body>
</html>