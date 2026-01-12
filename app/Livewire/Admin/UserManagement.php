<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    public $users;
    public $name, $email, $password, $user_id;
    public $role = 'karyawan'; // default role
    public $isEdit = false;
    public $search = ''; // ditambahkan karena ada wire:model="search" di view
    public $roles; // untuk menyimpan daftar roles

    public function mount()
    {
        // Load semua roles yang tersedia
        $this->roles = Role::all();
    }

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->users = $query->latest()->get();
        return view('livewire.admin.user-management');
    }

    // wrapper submit: panggil store() atau update() sesuai mode
    public function submit()
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign role ke user
        $user->assignRole($this->role);

        $this->resetInput();
        session()->flash('success', 'User berhasil ditambahkan dengan role ' . $this->role . '.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        // Set role dari user (ambil role pertama jika ada)
        $this->role = $user->roles->first()?->name ?? 'karyawan';
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Update role user (hapus semua role lalu assign role baru)
        $user->syncRoles([$this->role]);

        $this->resetInput();
        session()->flash('success', 'User berhasil diperbarui dengan role ' . $this->role . '.');
    }

    public function delete($id)
    {
        User::destroy($id);
        session()->flash('success', 'User berhasil dihapus.');
    }

    // <-- ubah jadi public supaya bisa dipanggil dari wire:click
    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'karyawan';
        $this->user_id = null;
        $this->isEdit = false;
    }
}
