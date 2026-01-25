<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-indigo-50">
        
        {{-- Logo & Judul --}}
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-indigo-600 tracking-tighter">Skyguts<span class="text-gray-800">Wallet</span></h1>
            <p class="text-gray-500 mt-2 text-sm">Kelola keuanganmu dengan lebih bijak.</p>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl shadow-indigo-100 overflow-hidden sm:rounded-3xl border border-white">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="relative">
                    <label for="email" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Email Address</label>
                    <input id="email" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs text-indigo-500 hover:text-indigo-700 font-semibold" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    
                    <input id="password" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mt-6">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer" name="remember">
                        <span class="ms-2 text-sm text-gray-500 group-hover:text-gray-700 transition">Ingat saya</span>
                    </label>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Masuk ke Akun
                    </button>
                </div>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-400 font-medium">atau lanjutkan dengan</span>
                    </div>
                </div>

                <a href="{{ route('auth.google') }}" class="relative flex items-center justify-center w-full px-4 py-3.5 border border-gray-200 rounded-xl bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-200 group">
                    <img class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform duration-200" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo">
                    <span>Google</span>
                </a>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

            </form>
        </div>
        
        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Skyguts-Wallet App. Aman & Terpercaya.
        </div>
    </div>
</x-guest-layout>