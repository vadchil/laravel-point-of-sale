<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Dashboard;
use App\Models\User;
use Spatie\Permission\Models\Role; // jika menggunakan spatie/laravel-permission
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_redirects_to_admin_dashboard()
    {
        $user = User::factory()->create();
        Role::create(['name'=>'admin']);
        $user->assignRole('admin');

        $this->actingAs($user);

        Livewire::test(Dashboard::class)
            ->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function karyawan_user_redirects_to_karyawan_penjualan()
    {
        $user = User::factory()->create();
        Role::create(['name'=>'karyawan']);
        $user->assignRole('karyawan');

        $this->actingAs($user);

        Livewire::test(Dashboard::class)
            ->assertRedirect(route('karyawan.penjualan'));
    }

    /** @test */
    public function user_with_unknown_role_gets_forbidden()
    {
        $user = User::factory()->create();
        // tanpa role atau role lain
        $this->actingAs($user);

        Livewire::test(Dashboard::class)
            ->assertForbidden();
    }
}
