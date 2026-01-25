<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SkygutsWallet - Kelola Keuangan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen text-gray-800 font-sans">
        
        <div class="relative min-h-screen flex flex-col justify-center items-center selection:bg-indigo-500 selection:text-white">
            
            {{-- Navigasi Atas --}}
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition mr-4">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-bold bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            {{-- Konten Utama --}}
            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
                
                {{-- Logo Animasi --}}
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-4 rounded-3xl shadow-xl shadow-indigo-100 animate-bounce">
                        <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Skyguts<span class="text-indigo-600">Wallet</span>
                </h1>
                
                <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto mb-8">
                    Aplikasi pencatat keuangan pribadi yang simpel, modern, dan membantu Anda mencapai kebebasan finansial.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-1">
                        🚀 Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-xl bg-white text-indigo-600 border border-indigo-100 font-bold text-lg shadow-sm hover:bg-gray-50 transition transform hover:-translate-y-1">
                        Masuk Akun
                    </a>
                </div>

                {{-- Footer Kecil --}}
                <div class="mt-16 text-sm text-gray-400">
                    &copy; {{ date('Y') }} DompetKu App. Built with Laravel & Tailwind.
                </div>
            </div>
        </div>
    </body>
</html>