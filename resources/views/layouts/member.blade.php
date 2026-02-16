<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- CONTENT --}}
    <main class="ml-64 p-6">
        @yield('container')
    </main>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


</body>
</html>
