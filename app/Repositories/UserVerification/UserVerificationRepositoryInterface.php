<?php

namespace App\Repositories\UserVerification;

use App\UserVerification;

interface UserVerificationRepositoryInterface
{
    public function getByToken(string $token, string $email);
    public function store(array $data): UserVerification;
}
