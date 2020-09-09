<?php

namespace App\Repositories\Location;

use App\Location;
use Illuminate\Database\Eloquent\Collection;

interface LocationRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Location;
    public function store(array $data): Location;
    public function update(int $id, array $data): Location;
    public function destroy(int $id);
}
