<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MindCare Connect | Secure Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen w-full flex flex-col justify-center items-center pt-6 sm:pt-0 bg-slate-50">
            
            <!-- Custom Healthcare Logo -->
            <div class="mb-4 text-center">
                <a href="/" class="flex flex-col items-center gap-3">
                    <div class="p-4 rounded-2xl shadow-lg" style="background-color: #0d9488;">
                        <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-3H6v-2h3V9h2v3h3v2h-3v3z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-3xl text-slate-800 tracking-tight mt-2">MindCare<span style="color: #0d9488;">Connect</span></span>
                    <span class="text-sm text-slate-500 font-medium tracking-widest uppercase">Secure Patient Portal</span>
                </a>
            </div>

            <!-- Login Box Container (Fixed with mx-auto and w-full!) -->
            <div class="w-full sm:max-w-md mx-auto mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-slate-100">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} MindCare Connect. HIPAA Compliant System.
            </div>
        </div>
    </body>
</html>