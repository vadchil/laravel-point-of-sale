<div>
    <x-card title="Riwayat Penjualan" subtitle="Lihat dan kelola riwayat transaksi">
        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <x-alert 
                type="{{ str_contains(session('message'), 'Berhasil') || str_contains(session('message'), 'berhasil') ? 'success' : 'info' }}" 
                class="mb-6" 
                dismissible
            >
                {{ session('message') }}
            </x-alert>
        @endif

        {{-- Filter & Search --}}
        <div class="mb-6 space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
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
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Cari Produk
                    </label>
                    <x-search-input 
                        placeholder="Cari nama produk..." 
                        wire:model.debounce.500ms="search"
                    />
                </div>
                <div class="flex items-end">
                    <x-button
                        variant="danger"
                        wire:click="deleteByDateRange"
                        wire:confirm="Apakah Anda yakin ingin menghapus riwayat dalam rentang tanggal ini? Tindakan ini tidak dapat dibatalkan."
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="deleteByDateRange">Hapus Riwayat</span>
                        <span wire:loading wire:target="deleteByDateRange">Menghapus...</span>
                    </x-button>
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
                    <x-table.header>Tanggal</x-table.header>
                    <x-table.header>Produk</x-table.header>
                    <x-table.header>Kategori</x-table.header>
                    <x-table.header>Qty</x-table.header>
                    <x-table.header>Harga</x-table.header>
                    <x-table.header class="text-right">Total</x-table.header>
                </x-table.head>
                <x-table.body>
                    @foreach($sales as $penjualan)
                        @foreach($penjualan->produk as $produk)
                            <x-table.row>
                                <x-table.cell>
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y') }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell class="font-medium">{{ $produk->namaproduk }}</x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $produk->kategori }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell>{{ $produk->pivot->jumlah }}</x-table.cell>
                                <x-table.cell>Rp {{ number_format($produk->pivot->harga_saat_itu, 0, ',', '.') }}</x-table.cell>
                                <x-table.cell class="text-right font-semibold">
                                    Rp {{ number_format($produk->pivot->jumlah * $produk->pivot->harga_saat_itu, 0, ',', '.') }}
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    @endforeach
                </x-table.body>
            </x-table>
        @endif
    </x-card>
</div>