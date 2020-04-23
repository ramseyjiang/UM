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
            'email' => 'finalTest@qq.com',
            'first_name' => 'finalTest',
            'last_name' => 'finalTest',
            'is_admin' => '0',
            'username' => 'finalTest',
            'password' => '123456',
        ];

        $response = $this->post('api/register', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure([ 'access_token', 'token_type']);

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
        $user = $this->createUser();

        $response = $this->post('api/login', [
            'username'    => $user->username,
            'password' => '123456'
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([ 'access_token', 'token_type']);
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
        $this->get('api/logout', $this->headers())
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(['message']);
    }

    public function testUser()
    {
        $url = 'api/user';

        // Test unauthenticated access.
        $this->get($url)
        ->assertStatus(Response::HTTP_FOUND);

        // Test authenticated access.
        $this->get($url, $this->headers())
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([ 'id', 'first_name', 'last_name', 'username', 'email']);
    }

    public function testList()
    {
        $url = 'api/list';

        $this->get($url)
        ->assertStatus(Response::HTTP_OK);
    }
}
