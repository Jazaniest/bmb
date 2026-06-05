<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BMB Tour & Travel - Solusi Umrah & Haji Premium')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-teal-800 selection:text-white">

    @include('components.navbar')

    <main class="grow animate-fade-in">
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>