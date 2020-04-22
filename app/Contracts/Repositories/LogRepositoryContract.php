<?php

namespace Um\Contracts\Repositories;

interface LogRepositoryContract 
{
    public function createUserOperateLog(object $user, string $desc);

    public function updateUserOperateLog(object $user, string $desc);

    public function deleteUserOperateLog(object $user, string $desc);
}