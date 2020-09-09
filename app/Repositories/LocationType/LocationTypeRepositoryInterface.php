<?php

namespace App\Repositories\LocationType;

use App\LocationType;
use Illuminate\Database\Eloquent\Collection;

interface LocationTypeRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): LocationType;
    public function store(array $data): LocationType;
    public function update(int $id, array $data): LocationType;
    public function destroy(int $id);
}
