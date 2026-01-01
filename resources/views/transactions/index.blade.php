<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-32">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-700">
                            Laporan Bulan: {{ \Carbon\Carbon::parse($filterDate)->translatedFormat('F Y') }}
                        </h3>
                        
                        <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center gap-2">
                            <label for="date" class="text-gray-600 text-sm">Pilih Bulan:</label>
                            <input type="month" name="date" value="{{ $filterDate }}" 
                                onchange="this.form.submit()" 
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </form>
                    </div>
                   

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-green-100 p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                            <p class="text-green-600 text-sm font-bold uppercase">Total Pemasukan</p>
                            <p class="text-2xl font-bold text-green-800">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-red-100 p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                            <p class="text-red-600 text-sm font-bold uppercase">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-red-800">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-blue-100 p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                            <p class="text-blue-600 text-sm font-bold uppercase">Sisa Saldo</p>
                            <p class="text-2xl font-bold text-blue-800">
                                Rp {{ number_format($saldo, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    

                    <div class="mb-4">
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Transaksi
                        </a>
                    </div>

                    <div class="block md:hidden">
                        @forelse($transactions as $transaction)
                        <div class="bg-gray-50 p-4 mb-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs text-gray-500">
                                    {{ $transaction->date }}
                                </span>
                                <span class="font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <h4 class="text-lg font-bold text-gray-800 mb-1">
                                {{ $transaction->title }}
                            </h4>

                            <div class="flex items-center gap-2 mb-3 text-sm">
                                <span class="bg-white border px-2 py-1 rounded text-xs text-gray-600">
                                    {{ $transaction->category }}
                                </span>
                                <span class="{{ $transaction->type == 'income' ? 'text-green-500' : 'text-red-500' }} text-xs font-semibold uppercase">
                                    {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </div>

                            <div class="flex justify-end items-center border-t border-gray-200 pt-3 mt-2">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="flex items-center gap-4">
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-blue-600 font-semibold text-sm">
                                        Edit
                                    </a>
                                    
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6 text-gray-500">
                            Belum ada data transaksi.
                        </div>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                    <th class="px-4 py-2 text-left">Kategori</th>
                                    <th class="px-4 py-2 text-left">Jenis</th>
                                    <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $transaction->date }}</td>
                                    <td class="px-4 py-2">{{ $transaction->title }}</td>
                                    <td class="px-4 py-2">{{ $transaction->category }}</td>
                                    <td class="px-4 py-2">
                                        @if($transaction->type == 'income')
                                            <span class="text-green-600 font-bold">Pemasukan</span>
                                        @else
                                            <span class="text-red-600 font-bold">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right font-bold">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center px-4 py-6 text-gray-500">
                                        Belum ada data transaksi. Yuk tambah baru!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

</x-app-layout>