<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-indigo-50">
        
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-indigo-600 tracking-tighter">Dompet<span class="text-gray-800">Ku</span></h1>
            <p class="text-gray-500 mt-2 text-sm">Buat akun baru dan mulai atur keuanganmu.</p>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl shadow-indigo-100 overflow-hidden sm:rounded-3xl border border-white">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label for="name" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Nama Lengkap</label>
                    <input id="name" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-5">
                    <label for="email" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Email Address</label>
                    <input id="email" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-5">
                    <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Password</label>
                    <input id="password" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block">Konfirmasi Password</label>
                    <input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 py-3 px-4 text-gray-800 font-medium" 
                           type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a class="text-sm text-gray-600 hover:text-indigo-600 font-medium transition" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>

                    <button type="submit" class="ml-4 justify-center py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-400 font-medium">atau daftar dengan</span>
                    </div>
                </div>

                <a href="{{ route('auth.google') }}" class="relative flex items-center justify-center w-full px-4 py-3.5 border border-gray-200 rounded-xl bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-200 group">
                    <img class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform duration-200" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo">
                    <span>Google</span>
                </a>
            </form>
        </div>
    </div>
</x-guest-layout>