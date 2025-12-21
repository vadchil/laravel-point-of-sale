<div>
    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <x-alert 
            type="{{ str_contains(session('message'), 'berhasil') || str_contains(session('message'), 'sukses') ? 'success' : 'error' }}" 
            class="mb-6" 
            dismissible
        >
            {{ session('message') }}
        </x-alert>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 lg:gap-8">
        {{-- KATEGORI & DAFTAR PRODUK --}}
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                {{-- Filter Kategori --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kategori</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['all' => 'Semua', 'Alat Tulis' => 'Alat Tulis', 'Aksesoris' => 'Aksesoris', 'Buku' => 'Buku', 'Print Copy' => 'Print Copy'] as $kat => $label)
                            <x-button
                                variant="{{ $kategori === $kat ? 'primary' : 'outline' }}"
                                size="sm"
                                wire:click="filterKategori('{{ $kat }}')"
                                wire:loading.attr="disabled"
                            >
                                {{ $label }}
                            </x-button>
                        @endforeach
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Produk</h3>
                    
                    <div wire:loading.delay class="mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memuat produk...
                        </div>
                    </div>

                    @if($produkSemua->isEmpty())
                        <x-empty-state
                            title="Tidak ada produk"
                            description="Tidak ada produk dalam kategori yang dipilih."
                        />
                    @else
                        <x-table>
                            <x-table.head>
                                <x-table.header>Produk</x-table.header>
                                <x-table.header>Qty</x-table.header>
                                <x-table.header>Kategori</x-table.header>
                                <x-table.header>Harga</x-table.header>
                                <x-table.header class="text-right">Aksi</x-table.header>
                            </x-table.head>
                            <x-table.body>
                                @foreach($produkSemua as $produk)
                                    <x-table.row>
                                        <x-table.cell class="font-medium">{{ $produk->namaproduk }}</x-table.cell>
                                        <x-table.cell>
                                            <input 
                                                type="number" 
                                                min="1" 
                                                wire:model.defer="jumlah.{{ $produk->id }}"
                                                class="w-20 px-2 py-1 border border-gray-300 rounded-lg text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $produk->kategori }}
                                            </span>
                                        </x-table.cell>
                                        <x-table.cell class="font-semibold">
                                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </x-table.cell>
                                        <x-table.cell class="text-right">
                                            <x-button
                                                variant="success"
                                                size="sm"
                                                wire:click="tambahKeKeranjang({{ $produk->id }})"
                                                wire:loading.attr="disabled"
                                            >
                                                Tambah
                                            </x-button>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforeach
                            </x-table.body>
                        </x-table>
                    @endif
                </div>
            </x-card>
        </div>

        {{-- KERANJANG BELANJA --}}
        <div class="lg:col-span-1">
            <x-card title="Keranjang Belanja" class="sticky top-4">
                @if(empty($keranjang))
                    <x-empty-state
                        title="Keranjang kosong"
                        description="Tambahkan produk ke keranjang untuk memulai."
                    />
                @else
                    {{-- Daftar Item --}}
                    <div class="space-y-3 mb-6 max-h-72 overflow-y-auto pr-2">
                        @foreach($keranjang as $index => $item)
                            <div class="flex justify-between items-start gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm text-gray-900 dark:text-white truncate">
                                        {{ $item['nama'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Rp {{ number_format($item['jumlah'] * $item['harga'], 0, ',', '.') }}
                                    </p>
                                    <button 
                                        wire:click="hapusItem({{ $item['id'] }})"
                                        class="mt-1 text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total & Pembayaran --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900 dark:text-white">Total Harga:</span>
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </span>
                        </div>

                        <x-input
                            wire:model.lazy="uangPembeli"
                            type="number"
                            label="Uang Pembeli"
                            placeholder="0"
                            min="0"
                            :error="$uangPembeli > 0 && $uangPembeli < $totalHarga ? 'Uang tidak mencukupi' : null"
                        />

                        @if($uangPembeli >= $totalHarga && $uangPembeli > 0)
                            <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                    Kembalian: <span class="font-bold">Rp {{ number_format($uangPembeli - $totalHarga, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        @endif

                        <x-button
                            variant="success"
                            class="w-full"
                            wire:click="simpan"
                            wire:loading.attr="disabled"
                            :disabled="empty($keranjang) || $uangPembeli < $totalHarga"
                        >
                            <span wire:loading.remove wire:target="simpan">Simpan Belanjaan</span>
                            <span wire:loading wire:target="simpan">Menyimpan...</span>
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</div>