<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kaukaba Tour & Travel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Memanggil Komponen Navbar Global -->
    @include('components.navbar')

    <!-- Area Konten Dinamis Landing Page -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Memanggil Komponen Footer Global -->
    @include('components.footer')

</body>
</html>