<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPenggunaTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_cannot_access_admin_user_management()
    {
        $response = $this->get('/admin/pengguna');
        $response->assertRedirect('/login');
    }

    public function test_santri_cannot_access_admin_user_management()
    {
        $santri = User::factory()->create(['role' => 'santri']);

        $response = $this->actingAs($santri)->get('/admin/pengguna');
        $response->assertStatus(403); // Forbidden
    }

    public function test_admin_can_access_user_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/pengguna');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
    }

    public function test_admin_can_create_new_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/pengguna', [
            'name' => 'Santri Anyar',
            'email' => 'anyar@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'santri',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Santri Anyar',
            'email' => 'anyar@example.com',
            'role' => 'santri',
        ]);
    }

    public function test_admin_can_edit_existing_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create(['role' => 'santri', 'name' => 'Santri Lama']);

        $response = $this->actingAs($admin)->put("/admin/pengguna/{$target->id}", [
            'name' => 'Santri Diedit',
            'email' => 'lama_edit@example.com',
            'role' => 'admin', // Promote to admin
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'name' => 'Santri Diedit',
            'email' => 'lama_edit@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete("/admin/pengguna/{$admin->id}");
        
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_other_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create(['role' => 'santri']);

        $response = $this->actingAs($admin)->delete("/admin/pengguna/{$target->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }
}
