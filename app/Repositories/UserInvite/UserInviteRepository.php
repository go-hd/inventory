<?php

namespace App\Repositories\UserInvite;

use App\UserInvite;

/**
 * Class UserInviteRepository
 *
 * @package App\Repositories\UserInvite
 */
class UserInviteRepository implements UserInviteRepositoryInterface
{
    /**
     * @var UserInvite
     */
    private $userInvite;

    public function __construct(UserInvite $userInvite) {
        $this->userInvite = $userInvite;
    }

    /**
     * トークンから招待を1件取得する
     *
     * @param string $company_code
     * @param string $email
     * @param string $token
     * @return \App\UserInvite|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByToken(string $company_code, string $email, string $token)
    {
        return $this->userInvite->query()
            ->whereHas('company', function ($query) use ($company_code) {
            $query->where('company_code', $company_code);
            })
            ->where('email', $email)
            ->where('token', $token)
            ->first();
    }

    /**
     * ユーザー招待を登録する
     *
     * @param array $data
     * @return UserInvite
     * @throws \Exception
     */
    public function store(array $data): UserInvite
    {
        return $this->userInvite->create($data);
    }
}
