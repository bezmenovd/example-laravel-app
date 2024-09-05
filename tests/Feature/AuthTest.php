<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success(): void
    {
        $response = $this->post(route('auth.register'), [
            'email' => fake()->email(),
            'name' => fake()->name(),
            'password' => fake()->password(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_register_user_already_exists(): void
    {
        $response = $this->post(route('auth.register'), [
            'email' => $email=fake()->email(),
            'name' => fake()->name(),
            'password' => fake()->password(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

        $response = $this->post(route('auth.register'), [
            'email' => $email,
            'name' => fake()->name(),
            'password' => fake()->password(),
        ]);

        $response->assertStatus(403);
    }
    
    public function test_login_success(): void
    {
        $response = $this->post(route('auth.register'), [
            'email' => $email=fake()->email(),
            'name' => fake()->name(),
            'password' => $password=fake()->password(),
        ]);

        $response->assertStatus(200);

        $response = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertJsonStructure(['token']);
    }
    
    public function test_login_invalid_password(): void
    {
        $response = $this->post(route('auth.register'), [
            'email' => $email=fake()->email(),
            'name' => fake()->name(),
            'password' => $password=fake()->password(),
        ]);

        $response->assertStatus(200);

        $response = $this->post(route('auth.login'), [
            'email' => $email,
            'password' => fake()->password() . fake()->password(),
        ]);

        $response->assertStatus(400);
    }
}
