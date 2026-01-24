<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Edit Transaksi') }} ✏️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 relative">
                
                {{-- Hiasan Garis Atas (Warna Kuning/Orange biar beda dikit tanda Edit) --}}
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-yellow-400 to-orange-500"></div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- WAJIB ADA UNTUK EDIT --}}

                        <div>
                            <x-input-label for="title" :value="__('Keterangan Transaksi')" class="text-gray-600 font-bold" />
                            <input id="title" class="block mt-2 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-xl shadow-sm transition-all" 
                                type="text" name="title" :value="old('title', $transaction->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="amount" :value="__('Nominal (Rp)')" class="text-gray-600 font-bold" />
                                <div class="relative mt-2">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input id="amount" class="pl-10 block w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-xl shadow-sm transition-all" 
                                        type="number" name="amount" :value="old('amount', $transaction->amount)" required />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date" :value="__('Tanggal')" class="text-gray-600 font-bold" />
                                <input id="date" class="block mt-2 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-xl shadow-sm transition-all" 
                                    type="date" name="date" :value="old('date', $transaction->date)" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="type" :value="__('Jenis Transaksi')" class="text-gray-600 font-bold" />
                                <select id="type" name="type" class="block mt-2 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-xl shadow-sm cursor-pointer">
                                    <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>🔴 Pengeluaran</option>
                                    <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>🟢 Pemasukan</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category" :value="__('Kategori')" class="text-gray-600 font-bold" />
                                <select id="category" name="category" class="block mt-2 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-xl shadow-sm cursor-pointer">
                                    <option value="Makanan" {{ $transaction->category == 'Makanan' ? 'selected' : '' }}>🍽️ Makanan</option>
                                    <option value="Transportasi" {{ $transaction->category == 'Transportasi' ? 'selected' : '' }}>🚗 Transportasi</option>
                                    <option value="Hiburan" {{ $transaction->category == 'Hiburan' ? 'selected' : '' }}>🎬 Hiburan</option>
                                    <option value="Tagihan" {{ $transaction->category == 'Tagihan' ? 'selected' : '' }}>💡 Tagihan</option>
                                    <option value="Gaji" {{ $transaction->category == 'Gaji' ? 'selected' : '' }}>💰 Gaji</option>
                                    <option value="Belanja" {{ $transaction->category == 'Belanja' ? 'selected' : '' }}>🛍️ Belanja</option>
                                    <option value="Lainnya" {{ $transaction->category == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Bukti Foto (Opsional)')" class="text-gray-600 font-bold" />
                            
                            {{-- Preview Foto Lama --}}
                            @if($transaction->image)
                                <div class="mt-2 mb-4 p-2 border border-gray-200 rounded-lg inline-block bg-gray-50">
                                    <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $transaction->image) }}" alt="Bukti Transaksi" class="h-24 w-auto rounded-md shadow-sm">
                                </div>
                            @endif

                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-yellow-600 hover:text-yellow-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-yellow-500">
                                            <span>Ganti foto</span>
                                            <input id="image" name="image" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Biarkan kosong jika tidak ingin mengubah foto.
                                    </p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('transactions.index') }}" class="text-gray-500 hover:text-gray-700 font-medium mr-4 transition">
                                Batal
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                Update Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>