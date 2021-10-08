<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_users_can_see_products_list()
    {
        $products = Product::factory()->count(10)->create();

        $response = $this->getJson('/api/products');

        // $response->dump();

        $response->assertStatus(200)
            ->assertJsonPath('total', 10);
    }

    public function test_all_users_can_see_a_specific_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'status' => $product->status
            ]);
    }

    public function test_guest_users_can_not_create_product()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'My product 1',
            'description' => 'This is my product description',
            'price' => 20.50,
            'status' => true
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_logged_in_users_can_create_product()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'My product 1',
            'description' => 'This is my product description',
            'price' => 20.50,
            'status' => true
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201);

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', array_merge($data, ['slug' => Str::slug($data['name'])]));
    }

    public function test_logged_in_users_can_update_product()
    {
        $product = Product::factory()->create();

        $toUpdate = [
            'name' => 'Updated name',
            'description' => 'Updated Description',
            'price' => 20.00,
            'status' => 0
        ];

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->putJson("/api/products/{$product->id}", $toUpdate)
            ->assertStatus(200);

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', $toUpdate);
    }
}
