<?php

namespace App\Repositories\UserVerification;

use App\UserVerification;

/**
 * Class UserVerificationRepository
 *
 * @package App\Repositories\UserVerification
 */
class UserVerificationRepository implements UserVerificationRepositoryInterface
{
    /**
     * @var UserVerification
     */
    private $userVerification;

    public function __construct(UserVerification $userVerification) {
        $this->userVerification = $userVerification;
    }

    /**
     * トークンから取得する
     *
     * @param string $token
     * @param string $email
     * @return \App\UserVerification|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByToken(string $token, string $email)
    {
        return $this->userVerification->query()
            ->where('token', $token)
            ->whereNull('is_verified')
            ->where('email', $email)
            ->first();
    }

    /**
     * ユーザー認証を登録する
     *
     * @param array $data
     * @return UserVerification
     * @throws \Exception
     */
    public function store(array $data): UserVerification
    {
        return $this->userVerification->create($data);
    }
}
