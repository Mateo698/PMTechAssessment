<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_registers_a_user_and_returns_a_token()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'success',
                'message' => 'User registered successfully',
            ])
            ->assertJsonStructure([
                'authorization' => ['token', 'type']
            ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test] public function it_logs_in_a_user_and_returns_a_token()
    {
        User::create([
            'name' => 'Login User',
            'email' => 'login@example.com',
            'password' => Hash::make('validpassword'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'validpassword',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'success',
                'message' => 'User logged in successfully',
            ])
            ->assertJsonStructure([
                'authorization' => ['token', 'type']
            ]);
    }

    #[Test] public function it_rejects_invalid_login()
    {
        User::create([
            'name' => 'Fail User',
            'email' => 'fail@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'fail@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'error',
                'message' => 'Wrong credentials',
            ]);
    }

    #[Test] public function it_logs_out_an_authenticated_user()
    {
        // Register and login to get a token
        $this->postJson('/api/register', [
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => 'logoutpass',
        ]);

        $login = $this->postJson('/api/login', [
            'email' => 'logout@example.com',
            'password' => 'logoutpass',
        ]);

        $token = $login->json('authorization.token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/logout');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'success',
                'message' => 'User logged out successfully',
            ]);
    }
}
