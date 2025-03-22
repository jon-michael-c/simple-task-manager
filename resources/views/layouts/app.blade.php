<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="reorder-url" content="{{ route('tasks.reorder') }}">
    <title>Task Manager</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Header / Navigation -->
    <header class="bg-indigo-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">
                Simple Task Manager
            </h1>

        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

</body>

</html>