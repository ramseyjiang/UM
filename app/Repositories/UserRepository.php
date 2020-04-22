<?php

namespace Um\Repositories;

use Um\Contracts\Repositories\UserRepositoryContract;
use Um\Models\User;

class UserRepository implements UserRepositoryContract
{
    /**
     * Get all users info.
     *
     * @return void
     */
    public function getAllUsers()
    {

    }

    /**
     * Find a user info
     *
     * @param integer $userId
     * @return void
     */
    public function getUser(int $userId)
    {
        return User::find($userId);
    }

    /**
     * Create a user.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
    {
        return User::create([
            'first_name' => 123,
            'last_name' => 12333,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * Update a user.
     *
     * @param array $data
     * @return void
     */
    public function updateUser(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'username' => $data['username'],
        //     'email' => $data['email'],
        //     'password' => $data['password'],
        // ]);
    }

    public function deleteUser(int $id)
    {
        return User::where('id', $id)->delete();
    }
}