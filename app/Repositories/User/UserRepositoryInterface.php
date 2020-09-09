<?php

namespace App\Repositories\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): User;
    public function store(array $data): User;
    public function update(int $id, array $data): User;
    public function destroy(int $id);
}
