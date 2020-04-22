<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Um\Models\User;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function createUser()
    {
        $qq = mt_rand(1, 10000);
        $data = [
            'username' => $qq,
            'first_name' => $qq,
            'last_name' => $qq,
            'email' => $qq . '@qq.com',
            'password' => '12345678',
        ];
        return \Um\Models\User::create($data);
    }

    public function deleteUser($username = 'test')
    {
        \Um\Models\User::where('username',$username)->delete();
    }

    /**
     * Login the given user or create the first if none supplied.
     *
     * @param $user
     *
     * @return User
     */
    public function loginAsUser($user = null)
    {
        $user = User::first();
        $this->actingAs($user);
        return $user;
    }

    /**
     * Return request headers needed to interact with the API.
     *
     * @return Array array of headers.
     */
    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];
        if (!is_null($user)) {
            $token = \JWTAuth::fromUser($user);
            \JWTAuth::setToken($token);
            $headers['token'] = $token;
        }

        return $headers;
    }
}
