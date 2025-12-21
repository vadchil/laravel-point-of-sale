<div>
    <x-card title="Manajemen Barang" subtitle="Tambah dan kelola produk toko">
        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <x-alert type="success" class="mb-6" dismissible>
                {{ session('success') }}
            </x-alert>
        @endif

        {{-- Form Tambah Produk --}}
        <form wire:submit.prevent="store" class="space-y-4 mb-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-input
                    wire:model="namaproduk"
                    label="Nama Produk"
                    placeholder="Masukkan nama produk"
                    required
                    :error="$errors->first('namaproduk')"
                />

                <x-select
                    wire:model="kategori"
                    label="Kategori"
                    required
                    :error="$errors->first('kategori')"
                >
                    <option value="">Pilih kategori</option>
                    <option value="Alat Tulis">Alat Tulis</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Buku">Buku</option>
                    <option value="Print Copy">Print Copy</option>
                </x-select>

                <x-input
                    wire:model="harga"
                    type="number"
                    label="Harga"
                    placeholder="0"
                    min="0"
                    step="1"
                    required
                    :error="$errors->first('harga')"
                />
            </div>

            <div class="flex gap-2">
                <x-button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="store">Tambah Produk</span>
                    <span wire:loading wire:target="store">Menambahkan...</span>
                </x-button>
            </div>
        </form>

        {{-- Daftar Produk --}}
        <div class="mt-8">
            <div class="mb-4">
                <x-search-input 
                    placeholder="Cari produk..." 
                    wire:model.debounce.500ms="search"
                />
            </div>

            <div wire:loading.delay class="mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memuat data...
                </div>
            </div>

            @if($barangs->isEmpty())
                <x-empty-state
                    title="Belum ada produk"
                    description="Mulai dengan menambahkan produk pertama Anda."
                />
            @else
                <x-table>
                    <x-table.head>
                        <x-table.header>Nama Produk</x-table.header>
                        <x-table.header>Kategori</x-table.header>
                        <x-table.header>Harga</x-table.header>
                        <x-table.header class="text-right">Aksi</x-table.header>
                    </x-table.head>
                    <x-table.body>
                        @foreach ($barangs as $barang)
                            <x-table.row>
                                <x-table.cell class="font-medium">{{ $barang->namaproduk }}</x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $barang->kategori }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell class="font-semibold">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </x-table.cell>
                                <x-table.cell class="text-right">
                                    <x-button
                                        variant="danger"
                                        size="sm"
                                        wire:click="delete({{ $barang->id }})"
                                        wire:confirm="Apakah Anda yakin ingin menghapus produk ini?"
                                    >
                                        Hapus
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