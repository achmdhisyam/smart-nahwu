<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ProfilDanPasswordTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_cannot_access_profile_settings()
    {
        $response = $this->get('/profil');
        $response->assertRedirect('/login');
    }

    public function test_user_can_access_profile_settings()
    {
        $user = User::factory()->create(['role' => 'santri']);

        $response = $this->actingAs($user)->get('/profil');
        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_user_can_update_profile_info()
    {
        $user = User::factory()->create(['role' => 'santri']);

        $response = $this->actingAs($user)->post('/profil', [
            'name' => 'Santri Baru',
            'email' => 'santibaru@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Santri Baru',
            'email' => 'santibaru@example.com',
        ]);
    }

    public function test_user_can_change_password()
    {
        $user = User::factory()->create([
            'role' => 'santri',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->post('/profil/password', [
            'current_password' => 'password123',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('passwordbaru123', $user->fresh()->password));
    }

    public function test_user_can_request_forgot_password_link()
    {
        $user = User::factory()->create([
            'email' => 'santi@example.com',
            'role' => 'santri',
        ]);

        $response = $this->post('/lupa-password', [
            'email' => 'santi@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
    }
}
