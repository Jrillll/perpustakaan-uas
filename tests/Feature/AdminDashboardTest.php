<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_can_be_accessed_with_admin_session(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->withSession([
            'user_id' => $admin->id,
            'role' => 'admin',
        ])->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
    }

    public function test_admin_can_create_a_category(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->withSession([
            'user_id' => $admin->id,
            'role' => 'admin',
        ])->post('/admin/categories', [
            'name' => 'Fiksi',
            'description' => 'Buku fiksi',
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'Fiksi',
        ]);
    }
}
