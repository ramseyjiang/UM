<?php

namespace Um\Repositories;

use Um\Contracts\Repositories\UserRepositoryContract;
use Um\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryContract
{
    /**
     * Get all users info.
     *
     * @return void
     */
    public function getAllUsers()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    /**
     * Find a user info
     *
     * @param integer $userId
     * @return void
     */
    public function getUser(int $userId)
    {
        return User::findOrFail($userId);
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
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_admin' => $data['is_admin'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Update a user.
     *
     * @param array $data
     * @return void
     */
    public function updateUser(array $data, int $userId)
    {
        return User::where('id', $userId)
        ->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_admin' => $data['is_admin'],
            // 'username' => $data['username'], //When update a use info username in this version, it cannot be update.
            // 'email' => $data['email'],   //When update a use info email in this version, it cannot be update.
            'password' => Hash::make($data['password'])
        ]);
    }

    public function deleteUser(int $id)
    {
        return User::where('id', $id)->delete();
    }
}