<div>
    <x-card title="Riwayat Penjualan Saya" subtitle="Lihat riwayat transaksi penjualan Anda">
        {{-- Filter Tanggal --}}
        <div class="mb-6 space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Dari Tanggal
                    </label>
                    <input 
                        type="date" 
                        wire:model.lazy="tanggalAwal" 
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Sampai Tanggal
                    </label>
                    <input 
                        type="date" 
                        wire:model.lazy="tanggalAkhir" 
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                </div>
            </div>
        </div>

        {{-- Loading State --}}
        <div wire:loading.delay class="mb-4">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memuat data...
            </div>
        </div>

        {{-- Tabel Penjualan --}}
        @if($sales->isEmpty())
            <x-empty-state
                title="Tidak ada data penjualan"
                description="Tidak ada data penjualan dalam rentang tanggal yang dipilih."
            />
        @else
            <x-table>
                <x-table.head>
                    <x-table.header>Tanggal & Waktu</x-table.header>
                    <x-table.header>Jumlah Produk</x-table.header>
                    <x-table.header class="text-right">Total Harga</x-table.header>
                    <x-table.header class="text-right">Aksi</x-table.header>
                </x-table.head>
                <x-table.body>
                    @foreach($sales as $penjualan)
                        <x-table.row>
                            <x-table.cell>
                                <div class="text-sm">
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y') }}
                                    </div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">
                                        {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('H:i:s') }}
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $penjualan->penjualanProduk->count() }} item
                                </span>
                            </x-table.cell>
                            <x-table.cell class="text-right font-semibold">
                                Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
                            </x-table.cell>
                            <x-table.cell class="text-right">
                                <x-button
                                    variant="outline"
                                    size="sm"
                                    wire:click="showDetail({{ $penjualan->id }})"
                                >
                                    Detail
                                </x-button>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table.body>
            </x-table>

            {{-- Summary --}}
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Total Transaksi: <span class="font-semibold">{{ $sales->count() }}</span>
                    </span>
                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                        Total: Rp {{ number_format($sales->sum('total_harga'), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Modal Detail Transaksi --}}
        @if($selectedPenjualan)
            <div 
                class="fixed inset-0 z-50 overflow-y-auto" 
                x-data="{ show: true }"
                x-show="show"
                x-cloak
                style="display: block;"
            >
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    {{-- Backdrop --}}
                    <div 
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                        x-show="show"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click="show = false; $wire.closeDetail()"
                    ></div>

                    {{-- Modal Panel --}}
                    <div 
                        class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full"
                        x-show="show"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Detail Transaksi
                                </h3>
                                <button 
                                    type="button"
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                    @click="show = false; $wire.closeDetail()"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Info Transaksi --}}
                            <div class="mb-6 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Tanggal:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($selectedPenjualan->tanggal)->format('d M Y H:i:s') }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Harga:</span>
                                    <span class="font-semibold text-lg text-gray-900 dark:text-white">
                                        Rp {{ number_format($selectedPenjualan->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Daftar Produk --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                    Daftar Produk ({{ $selectedPenjualan->penjualanProduk->count() }} item)
                                </h4>
                                <div class="overflow-x-auto">
                                    <x-table>
                                        <x-table.head>
                                            <x-table.header>Produk</x-table.header>
                                            <x-table.header>Kategori</x-table.header>
                                            <x-table.header class="text-right">Qty</x-table.header>
                                            <x-table.header class="text-right">Harga Satuan</x-table.header>
                                            <x-table.header class="text-right">Subtotal</x-table.header>
                                        </x-table.head>
                                        <x-table.body>
                                            @foreach($selectedPenjualan->penjualanProduk as $item)
                                                <x-table.row>
                                                    <x-table.cell class="font-medium">
                                                        {{ $item->produk->namaproduk ?? 'Produk tidak ditemukan' }}
                                                    </x-table.cell>
                                                    <x-table.cell>
                                                        @if($item->produk)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                                {{ $item->produk->kategori }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </x-table.cell>
                                                    <x-table.cell class="text-right">{{ $item->jumlah }}</x-table.cell>
                                                    <x-table.cell class="text-right">
                                                        Rp {{ number_format($item->harga_saat_itu, 0, ',', '.') }}
                                                    </x-table.cell>
                                                    <x-table.cell class="text-right font-semibold">
                                                        Rp {{ number_format($item->jumlah * $item->harga_saat_itu, 0, ',', '.') }}
                                                    </x-table.cell>
                                                </x-table.row>
                                            @endforeach
                                        </x-table.body>
                                    </x-table>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <x-button
                                variant="primary"
                                @click="show = false; $wire.closeDetail()"
                            >
                                Tutup
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-card>
</div>
