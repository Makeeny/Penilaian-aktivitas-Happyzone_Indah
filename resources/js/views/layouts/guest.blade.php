<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
  <title>Happy Zone - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- CSS untuk bentuk blob di background --}}
        <style>
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at 15% 80%, #a78bfa 15%, transparent 40%);
                opacity: 0.5;
                z-index: 0;
            }
            body::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at 85% 20%, #a78bfa 15%, transparent 40%);
                opacity: 0.5;
                z-index: 0;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
    <div>
        <a href="/">
            <div class="flex items-center justify-center w-20 h-20 bg-purple-600 rounded-2xl shadow-lg">
                <span class="text-white text-4xl font-bold">HZ</span>
            </div>
        </a>
    </div>

    {{-- card auth --}}
    <div class="w-full max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden rounded-2xl">
        @yield('content')
    </div>
</div>

    </body>
</html>