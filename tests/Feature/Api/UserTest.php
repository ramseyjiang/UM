<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Um\Models\User;

class UserTest extends TestCase
{
    public function testApiRegister()
    {
        $this->deleteUser();

        $data = [
            'email' => 'test@qq.com',
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'test',
            'password' => '123456',
        ];

        $response = $this->post('api/register', $data);
        
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([ 'access_token', 'token_type', 'expires_in']);

        $this->assertDatabaseHas('users', [
            'email'  => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
        ]);
    }

    /**
     * Test for username login by api.
     *
     * @return void
     */
    public function testApiLoginByUsername()
    {
        $response = $this->post('api/login', [
            'username'    => 'test',
            'password' => '123456'
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([ 'access_token', 'token_type', 'expires_in']);
    }
    
    public function testApiUsernameLoginFail()
    {
        $response = $this->post('api/login', [
            'username'    => 'test',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function testLogout()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);
        $this->get('api/logout?token=' . $token)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(['message']);

        $this->assertGuest('api');
    }

    // public function testUser()
    // {
    //     $url = 'api/user';

    //     // Test unauthenticated access.
    //     $this->get($url, $this->headers())
    //     ->assertStatus(Response::HTTP_FOUND);

    //     // Test authenticated access.
    //     $this->get($url, $this->headers(User::first()))
    //     ->assertStatus(Response::HTTP_OK)
    //     ->assertJsonStructure([ 'id', 'first_name', 'last_name', 'username', 'email']);
    // }

    public function testRefresh()
    {
        $url = 'api/refresh';

        // Test unauthenticated access.
        $this->post($url, $this->headers())
        ->assertStatus(Response::HTTP_FOUND);

        // Test authenticated access.
        $this->post($url, $this->headers(User::first()))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([ 'access_token', 'token_type', 'expires_in']);
    }
}
