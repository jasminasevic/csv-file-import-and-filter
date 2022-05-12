<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_new_users(){

        $response = $this->post('api/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test2@email.com',
            'password' => 'test123',
            'password_confirmation' => 'test123',
            'role_id' => 1
        ]);

        $response->assertStatus(201);
    }

    public function test_login_user(){

        $response = $this->post('api/auth/login', [
            'email' => 'test1@email.com',
            'password' => 'test123'
        ]);

        $response->assertStatus(201);
    }
}
