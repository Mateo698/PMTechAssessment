<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    private function authenticate(): string
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        return $response->json('authorization.token');
    }

    #[Test] public function it_creates_a_product()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/products/new', [
            'name' => 'Test Product',
            'description' => 'Test Desc',
            'code' => 'TP001',
            'status' => true,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Product']);
    }

    #[Test] public function it_gets_all_products()
    {
        $token = $this->authenticate();

        Product::create([
            'name' => 'P1',
            'description' => 'Desc',
            'code' => 'P001',
            'status' => true,
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'P1']);
    }

    #[Test] public function it_gets_a_product_by_id()
    {
        $token = $this->authenticate();

        $product = Product::create([
            'name' => 'P1',
            'description' => 'Desc',
            'code' => 'P001',
            'status' => true,
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->get("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'P1']);
    }

    #[Test] public function it_updates_a_product()
    {
        $token = $this->authenticate();

        $product = Product::create([
            'name' => 'Old',
            'description' => 'Old',
            'code' => 'OLD',
            'status' => true,
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->putJson("/api/products/{$product->id}", [
            'name' => 'Updated',
            'description' => 'Updated Desc',
            'code' => 'UPD001',
            'status' => false,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Product updated']);
    }

    #[Test] public function it_deletes_a_product()
    {
        $token = $this->authenticate();

        $product = Product::create([
            'name' => 'ToDelete',
            'description' => 'Some desc',
            'code' => 'DEL123',
            'status' => true,
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->delete("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Product deleted']);
    }
}
