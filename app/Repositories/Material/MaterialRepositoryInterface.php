<?php

namespace App\Repositories\Material;

use App\Material;
use Illuminate\Database\Eloquent\Collection;

interface MaterialRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Material;
    public function store(array $data): Material;
    public function update(int $id, array $data): Material;
    public function updateMulti(array $materials, array $deleted_ids = []);
    public function destroy(int $id);
}
