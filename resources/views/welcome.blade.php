<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Twitter ni Rodwin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg px-10 py-12 bg-white border border-blue-900/20 shadow-xl rounded-3xl">

        <!-- Logo + Title -->
        <div class="flex flex-col items-center gap-4 mb-8">
            <img src="/twitterlogo.png" 
                 class="w-20 h-20 object-contain transition-transform duration-500 hover:rotate-6 hover:scale-105 drop-shadow-md">

            <h1 class="text-2xl font-bold text-blue-900 tracking-tight">Twitter ni Rodwin</h1>

            <p class="text-slate-600 text-sm font-medium">
                Join the conversation today.
            </p>
        </div>

        <!-- Login/Register Buttons -->
        @if (Route::has('login'))
            <div class="flex flex-col gap-4 items-center">

                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="w-3/4 py-3 text-base font-semibold text-blue-900 bg-white border-2 border-blue-900 rounded-full shadow
                              hover:bg-blue-900 hover:text-white hover:border-transparent
                              hover:shadow-[0_8px_20px_rgba(0,115,255,0.35)] hover:-translate-y-[3px] hover:scale-[1.04]
                              transition-all duration-300 text-center">
                        Go to Dashboard
                    </a>
                @else

                    <!-- Log in -->
                    <a href="{{ route('login') }}"
                       class="w-3/4 py-3 text-base font-semibold text-blue-900 bg-white border-2 border-blue-900 rounded-full shadow
                              hover:bg-blue-900 hover:text-white hover:border-transparent
                              hover:shadow-[0_8px_20px_rgba(0,115,255,0.35)] hover:-translate-y-[3px] hover:scale-[1.04]
                              transition-all duration-300 text-center">
                        Log in
                    </a>

                    <!-- Register -->
                    <a href="{{ route('register') }}"
                       class="w-3/4 py-3 text-base font-semibold text-blue-900 bg-white border-2 border-blue-900 rounded-full shadow
                              hover:bg-blue-900 hover:text-white hover:border-transparent
                              hover:shadow-[0_8px_20px_rgba(0,115,255,0.35)] hover:-translate-y-[3px] hover:scale-[1.04]
                              transition-all duration-300 text-center">
                        Register
                    </a>

                @endauth
            </div>
        @endif

        <!-- Footer -->
        <div class="mt-10 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} Twitter ni Rodwin. All rights reserved.
        </div>

    </div>

</body>
</html>
