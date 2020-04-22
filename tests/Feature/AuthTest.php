<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A register test
     *
     * @return void
     */
    public function testRegister()
    {
        $data = [
            'email' => 'test@qq.com',
            'username' => 'test',
            'password' => '123456',
        ];
        //Send post request
        $response = $this->call('POST', route('register'), $data);
        //Assert it was successful
        $response->assertStatus(Response::HTTP_FOUND);

        $this->deleteUser('test@qq.com');
    }

    /**
     * @test
     * Test username login
     */
    public function testUsernameLogin()
    {
        $user = $this->createUser();

        //attempt login
        $response = $this->call('POST', route('login'),[
            'username' => $user->username,
            'password' => '12345678',
        ]);
        //Assert it was successful and a token was received
        $response->assertStatus(Response::HTTP_FOUND);

        $this->deleteUser($user->id);
    }
}
