<?php

namespace Tests\Feature;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_products_index(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);

        $response = $this->actingAs($admin)->get('/admin/products');

        $response->assertStatus(200)
            ->assertSee('Product Management');
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'MacBook Pro M3',
            'code' => 'PRD-MBP-99',
            'category_id' => $category->id,
            'brand' => 'Apple',
            'serial_number' => 'SN-MBP-99',
            'location' => 'Ruang IT',
            'stock' => 10,
            'unit' => 'unit',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('products', [
            'code' => 'PRD-MBP-99',
            'name' => 'MacBook Pro M3',
        ]);
    }

    public function test_user_cannot_access_admin_product_creation(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);

        $response = $this->actingAs($user)->get('/admin/products/create');

        $response->assertStatus(403);
    }

    public function test_public_product_detail_page_is_accessible_via_qr_code(): void
    {
        $product = Product::factory()->create([
            'code' => 'PRD-TEST-123',
            'name' => 'Testing Scanner Product',
            'status' => ProductStatus::ACTIVE,
        ]);

        $response = $this->get('/product/PRD-TEST-123');

        $response->assertStatus(200)
            ->assertSee('Testing Scanner Product')
            ->assertSee('PRD-TEST-123');
    }
}
