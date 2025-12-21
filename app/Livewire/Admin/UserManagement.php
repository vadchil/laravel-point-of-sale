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
    public $isEdit = false;
    public $search = ''; // ditambahkan karena ada wire:model="search" di view

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
        ]);

        $role = Role::firstOrCreate(['name' => 'karyawan']);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole($role);
        }

        $this->resetInput();
        session()->flash('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
        ]);

        $user = User::find($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->resetInput();
        session()->flash('success', 'User berhasil diperbarui.');
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
        $this->user_id = null;
        $this->isEdit = false;
    }
}
