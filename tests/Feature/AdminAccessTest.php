<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login_for_admin_routes(): void
    {
        $this->get('/admin/categories')->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'status' => true,
            'is_admin' => false,
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_inactive_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->admin(false)->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }


    public function test_admin_login_is_rate_limited_after_repeated_failures(): void
    {
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $response = $this->post('/admin/login', [
                'email' => 'admin@aquapos.com',
                'password' => 'wrong-password',
            ]);
        }

        $response
            ->assertSessionHasErrors('email');
    }

    public function test_active_admin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk();
    }
}
