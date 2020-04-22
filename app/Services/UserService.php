<?php
namespace Um\Services;

use Um\Contracts\Services\UserServiceContract;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceContract
{
    /**
     * It is used to check username login.
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function checkLogin(string $username, string $password)
    {
        Auth::attempt(['username' => $username, 'password' => $password]);
    }
}