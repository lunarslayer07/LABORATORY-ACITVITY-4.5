<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CafeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
    }

    public function test_staff_can_create_order_with_multiple_items(): void
    {
        $user = User::factory()->create();
        $customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'phone' => '0700000000',
            'address' => '22 Test Lane',
        ]);

        $category = \App\Models\Category::create([
            'name' => 'Drinks',
            'description' => 'Hot drinks',
        ]);

        $coffee = Product::create([
            'category_id' => $category->id,
            'name' => 'Latte',
            'description' => 'Test product',
            'price' => 5.50,
            'stock_quantity' => 10,
            'is_available' => true,
        ]);

        $tea = Product::create([
            'category_id' => $category->id,
            'name' => 'Tea',
            'description' => 'Second test product',
            'price' => 4.00,
            'stock_quantity' => 8,
            'is_available' => true,
        ]);

        $response = $this->actingAs($user)->post('/orders', [
            'customer_id' => $customer->id,
            'items' => [
                ['product_id' => $coffee->id, 'quantity' => 2],
                ['product_id' => $tea->id, 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', ['customer_id' => $customer->id]);
    }
}
