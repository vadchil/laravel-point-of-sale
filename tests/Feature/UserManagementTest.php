<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_renders()
    {
        Livewire::test(\App\Livewire\Admin\UserManagement::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $email = 'john@example.com';

        Livewire::test(\App\Livewire\Admin\UserManagement::class)
            ->set('name', 'John Doe')
            ->set('email', $email)
            ->set('password', 'secret123')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => 'John Doe',
        ]);
    }

    /** @test */
    public function it_can_edit_and_update_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $component = Livewire::test(\App\Livewire\Admin\UserManagement::class)
            ->call('edit', $user->id)
            ->assertSet('user_id', $user->id)
            ->assertSet('name', 'Old Name')
            ->assertSet('email', 'old@example.com');

        // update values and call update()
        $component->set('name', 'New Name')
                  ->set('email', 'new@example.com')
                  ->call('update')
                  ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        Livewire::test(\App\Livewire\Admin\UserManagement::class)
            ->call('delete', $user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function reset_input_clears_fields_and_resets_edit_mode()
    {
        Livewire::test(\App\Livewire\Admin\UserManagement::class)
            ->set('name', 'Will Be Cleared')
            ->set('email', 'clear@example.com')
            ->set('password', 'somepass')
            ->set('isEdit', true)
            ->call('resetInput')
            ->assertSet('name', '')
            ->assertSet('email', '')
            ->assertSet('password', '')
            ->assertSet('user_id', null)
            ->assertSet('isEdit', false);
    }
}
