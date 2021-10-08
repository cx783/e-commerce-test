<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_all_users_can_checkout_products()
    {
        $products = Product::factory()->count(5)->create();

        $client = [
            'full_name' => $this->faker->name,
            'address' => $this->faker->address,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
        ];

        $productsCheckout = [
            [
                'product_id' => $products->get(0)->id,
                'price' => $products->get(0)->price,
                'quantity' => 1
            ],
            [
                'product_id' => $products->get(3)->id,
                'price' => $products->get(3)->price,
                'quantity' => 2
            ],
            [
                'product_id' => $products->get(4)->id,
                'price' => $products->get(4)->price,
                'quantity' => 3
            ]
        ];

        $response = $this->postJson('/api/checkout', array_merge(
            $client,
            [
                'items' => $productsCheckout,
                'payment' => [
                    'credit_card' => $this->faker->creditCardNumber,
                    'credit_card_expiration' => $this->faker->creditCardExpirationDate->format('m/y'),
                    'credit_card_cvv' => '123'
                ]
            ]
        ));

        $response->assertStatus(201);

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 3);
        $this->assertDatabaseCount('clients', 1);
        $this->assertDatabaseHas('clients', $client);
    }
}
