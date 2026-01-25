<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- KIRI: Judul & Badge Role --}}
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Dompet Saya 💰') }}
                </h2>

                @if(Auth::user()->role == 'admin')
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm border border-red-400">
                        Admin Mode
                    </span>
                @else
                    <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm border border-blue-400">
                        Member
                    </span>
                @endif
            </div>

            {{-- KANAN: Tombol Admin & Filter --}}
            <div class="flex items-center gap-3">
                
                {{-- TOMBOL KHUSUS ADMIN: CEK SALDO MEMBER --}}
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.users') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 border border-indigo-200 font-bold py-2 px-4 rounded-lg shadow-sm text-xs sm:text-sm transition flex items-center gap-2">
                        👥 <span class="hidden sm:inline">Cek Saldo Member</span>
                    </a>
                @endif

                {{-- Filter Bulan --}}
                <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center bg-white p-1 rounded-lg shadow-sm border border-gray-200">
                    <input type="month" name="date" value="{{ $filterDate }}" 
                        onchange="this.form.submit()" 
                        class="border-none focus:ring-0 text-sm text-gray-600 bg-transparent cursor-pointer">
                </form>
            </div>

        </div>
    </x-slot>

    <div class="py-12 pb-32">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BAGIAN 1: KARTU SALDO --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-4 sm:px-0">
                <div class="relative overflow-hidden bg-gradient-to-br from-green-400 to-green-600 rounded-2xl shadow-lg text-white p-6 transition transform hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-green-100 text-sm font-semibold uppercase tracking-wider">Total Pemasukan</p>
                    <p class="text-3xl font-bold mt-1">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-red-400 to-red-600 rounded-2xl shadow-lg text-white p-6 transition transform hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-red-100 text-sm font-semibold uppercase tracking-wider">Total Pengeluaran</p>
                    <p class="text-3xl font-bold mt-1">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </p>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg text-white p-6 transition transform hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Sisa Saldo</p>
                    <p class="text-3xl font-bold mt-1">
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- TOMBOL TAMBAH --}}
            <div class="flex justify-between items-center mb-6 px-4 sm:px-0">
                <h3 class="text-lg font-bold text-gray-700">Riwayat Transaksi</h3>
                <a href="{{ route('transactions.create') }}" class="group relative inline-flex items-center justify-center px-6 py-2 text-base font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700 shadow-lg">
                    <span>+ Transaksi Baru</span>
                    <div class="absolute inset-0 -z-10 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-200 bg-indigo-600"></div>
                </a>
            </div>

            {{-- BAGIAN 2: TAMPILAN MOBILE --}}
            <div class="block md:hidden px-4">
                @forelse($transactions as $transaction)
                <div class="bg-white p-5 mb-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                    
                    <div class="absolute left-0 top-0 bottom-0 w-1 {{ $transaction->type == 'income' ? 'bg-green-500' : 'bg-red-500' }}"></div>

                    {{-- Label Pemilik di Mobile (Khusus Admin) --}}
                    @if(Auth::user()->role == 'admin')
                    <div class="mb-2 flex items-center gap-2">
                        <span class="bg-gray-800 text-white text-[10px] px-2 py-0.5 rounded shadow-sm">
                            👤 {{ $transaction->user->name }}
                        </span>
                    </div>
                    @endif

                    <div class="flex justify-between items-start mb-2 pl-3">
                        <div>
                            <span class="text-[10px] font-bold tracking-wide text-gray-400 uppercase">{{ $transaction->date }}</span>
                            <h4 class="text-lg font-bold text-gray-800 leading-tight">{{ $transaction->title }}</h4>
                        </div>
                        <span class="font-bold text-lg {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }}
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mb-4 pl-3">
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-md font-medium">
                            📂 {{ $transaction->category }}
                        </span>
                        @if($transaction->image)
                        <a href="{{ asset('storage/' . $transaction->image) }}" target="_blank" class="text-xs text-indigo-500 hover:text-indigo-700 flex items-center gap-1 font-medium bg-indigo-50 px-2 py-1 rounded-md">
                            📸 Lihat Foto
                        </a>
                        @endif
                    </div>

                    <div class="flex justify-end gap-3 border-t border-gray-100 pt-3 pl-3">
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-gray-400 hover:text-indigo-600 text-sm font-medium transition">Edit</a>
                        <form onsubmit="return confirm('Hapus transaksi ini?');" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 text-sm font-medium transition">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-gray-400 text-sm">Belum ada transaksi bulan ini.</p>
                </div>
                @endforelse
            </div>

            {{-- BAGIAN 3: TAMPILAN DESKTOP --}}
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            
                            {{-- KOLOM KHUSUS ADMIN --}}
                            @if(Auth::user()->role == 'admin')
                            <th class="px-6 py-4 text-left text-xs font-bold text-red-500 uppercase tracking-wider">
                                Pemilik Dompet
                            </th>
                            @endif

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bukti</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                            </td>
                            
                            {{-- ISI KOLOM KHUSUS ADMIN --}}
                            @if(Auth::user()->role == 'admin')
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs mr-3">
                                        {{ substr($transaction->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $transaction->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $transaction->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            @endif

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $transaction->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                    {{ $transaction->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($transaction->image)
                                    <a href="{{ asset('storage/' . $transaction->image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto
                                    </a>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($transaction->type == 'income')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <form onsubmit="return confirm('Hapus data ini?');" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline-flex gap-2">
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            {{-- COLSPAN OTOMATIS: 8 Kalau Admin, 7 Kalau Member --}}
                            <td colspan="{{ Auth::user()->role == 'admin' ? 8 : 7 }}" class="px-6 py-10 text-center text-gray-500">
                                <p class="text-base">Belum ada data transaksi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>