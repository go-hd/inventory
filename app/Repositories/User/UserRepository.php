<?php

namespace App\Repositories\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 *
 * @package App\Repositories\User
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * ユーザー一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->user->query();
        $company_id = $params['company_id'] ?? null;

        if (!is_null($company_id)) {
            $query->whereHas('location', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->get();
        }

        return $query->orderBy('created_at', 'desc')->get()->makeHidden('products');
    }

    /**
     * ユーザーを1件取得する
     *
     * @param int $id
     * @return User
     */
    public function getOne(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * ユーザーを登録する
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function store(array $data): User
    {
        return $this->user->create($data);
    }

    /**
     * ユーザーを更新する
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function update(int $id, array $data): User
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);

        return $user;
    }

    /**
     * ユーザーを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
    }
}
