<div>
    <x-card 
        :title="$isEdit ? 'Edit User' : 'Tambah User Baru'" 
        subtitle="Kelola pengguna sistem"
    >
        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <x-alert type="success" class="mb-6" dismissible>
                {{ session('success') }}
            </x-alert>
        @endif

        @if (session()->has('error'))
            <x-alert type="error" class="mb-6" dismissible>
                {{ session('error') }}
            </x-alert>
        @endif

        {{-- Form User --}}
        <form wire:submit.prevent="submit" class="space-y-4 mb-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input
                    wire:model="name"
                    label="Nama"
                    placeholder="Nama lengkap"
                    required
                    :error="$errors->first('name')"
                />

                <x-input
                    wire:model="email"
                    type="email"
                    label="Email"
                    placeholder="email@example.com"
                    required
                    :error="$errors->first('email')"
                />

                @if (!$isEdit)
                    <x-input
                        wire:model="password"
                        type="password"
                        label="Password"
                        placeholder="Minimal 6 karakter"
                        required
                        :error="$errors->first('password')"
                    />
                @endif

                <x-select
                    wire:model="role"
                    label="Role"
                    required
                    :error="$errors->first('role')"
                >
                    <option value="">Pilih Role</option>
                    @foreach($roles as $roleOption)
                        <option value="{{ $roleOption->name }}">{{ ucfirst($roleOption->name) }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex gap-2">
                <x-button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        {{ $isEdit ? 'Update User' : 'Tambah User' }}
                    </span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </x-button>
                @if ($isEdit)
                    <x-button 
                        type="button" 
                        variant="outline"
                        wire:click="resetInput"
                        wire:loading.attr="disabled"
                    >
                        Batal
                    </x-button>
                @endif
            </div>
        </form>

        {{-- Daftar Users --}}
        <div class="mt-8">
            <div class="mb-4">
                <x-search-input 
                    placeholder="Cari user..." 
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

            @if($users->isEmpty())
                <x-empty-state
                    title="Belum ada user"
                    description="Mulai dengan menambahkan user pertama Anda."
                />
            @else
                <x-table>
                    <x-table.head>
                        <x-table.header>Nama</x-table.header>
                        <x-table.header>Email</x-table.header>
                        <x-table.header>Role</x-table.header>
                        <x-table.header class="text-right">Aksi</x-table.header>
                    </x-table.head>
                    <x-table.body>
                        @foreach ($users as $user)
                            <x-table.row>
                                <x-table.cell class="font-medium">{{ $user->name }}</x-table.cell>
                                <x-table.cell>{{ $user->email }}</x-table.cell>
                                <x-table.cell>
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $role->name === 'admin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">Tidak ada role</span>
                                    @endif
                                </x-table.cell>
                                <x-table.cell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-button
                                            variant="outline"
                                            size="sm"
                                            wire:click="edit({{ $user->id }})"
                                            wire:loading.attr="disabled"
                                        >
                                            Edit
                                        </x-button>
                                        <x-button
                                            variant="danger"
                                            size="sm"
                                            wire:click="delete({{ $user->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menghapus user ini?"
                                        >
                                            Hapus
                                        </x-button>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.body>
                </x-table>
            @endif
        </div>
    </x-card>
</div>