<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Edit Transaksi') }} ✏️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Judul --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Keterangan Transaksi</label>
                            <input type="text" name="title" value="{{ $transaction->title }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 py-3 px-4" required>
                        </div>

                        {{-- Grid 2 Kolom --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            {{-- Jumlah Uang --}}
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Nominal (Rp)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="amount" value="{{ $transaction->amount }}" class="w-full pl-10 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 py-3 px-4" required>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Tanggal</label>
                                <input type="date" name="date" value="{{ $transaction->date }}" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 py-3 px-4" required>
                            </div>
                        </div>

                        {{-- Grid 2 Kolom --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            {{-- Jenis --}}
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Jenis Transaksi</label>
                                <select name="type" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 py-3 px-4 cursor-pointer">
                                    <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>🔴 Pengeluaran</option>
                                    <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>🟢 Pemasukan</option>
                                </select>
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Kategori</label>
                                <select name="category" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 py-3 px-4 cursor-pointer">
                                    @foreach(['Makanan', 'Transportasi', 'Hiburan', 'Belanja', 'Gaji', 'Lainnya'] as $cat)
                                        <option value="{{ $cat }}" {{ $transaction->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Bukti Foto (Upload Baru jika ingin mengganti)</label>
                            
                            @if($transaction->image)
                                <div class="mb-2">
                                    <span class="text-xs text-gray-500">Foto saat ini:</span>
                                    <a href="{{ asset('storage/' . $transaction->image) }}" target="_blank" class="text-xs text-indigo-600 font-bold hover:underline">Lihat Foto</a>
                                </div>
                            @endif

                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition"/>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('transactions.index') }}" class="text-gray-500 hover:text-gray-700 font-bold px-4 py-2 transition">Batal</a>
                            <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition transform hover:-translate-y-0.5 shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>