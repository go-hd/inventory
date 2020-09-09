<?php

namespace App\Repositories\UserInvite;

use App\UserInvite;

interface UserInviteRepositoryInterface
{
    public function getByToken(string $company_code, string $email, string $token);
    public function store(array $data): UserInvite;
}
