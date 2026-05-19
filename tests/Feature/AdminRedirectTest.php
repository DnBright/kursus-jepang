<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminRedirectTest extends TestCase
{
    /**
     * Test that guest accessing /admin is redirected to admin login.
     */
    public function test_guest_accessing_admin_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test that authenticated admin accessing /admin is redirected to dashboard.
     */
    public function test_authenticated_admin_accessing_admin_is_redirected_to_dashboard(): void
    {
        $admin = new \App\Models\Admin([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin');

        $response->assertRedirect(route('admin.dashboard'));
    }
}
