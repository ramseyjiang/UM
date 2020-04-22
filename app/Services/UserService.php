<?php

namespace Um\Services;

use Um\Interfaces\UserInterface;
use Um\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    /**
     * Create a user.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'first_name' => 1,
            'last_name' => 1,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => 0
        ]);
    }

    /**
     * Get all users info.
     *
     * @return void
     */
    public function getAllUsers()
    {

    }

    /**
     * @inheritdoc
     */
    public function getUser(int $userId)
    {

    }

    /**
     * Update a user info.
     *
     * @param array $data
     * @return void
     */
    public function updateUser(array $data)
    {

    }

    /**
     * Delete a user info by userId.
     *
     * @param integer $userId
     * @return void
     */
    public function deleteUser(int $userId)
    {

    }
}