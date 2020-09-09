<?php

namespace App\Repositories\Lot;

use App\Lot;
use Illuminate\Database\Eloquent\Collection;

interface LotRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Lot;
    public function store(array $data): Lot;
    public function update(int $id, array $data): Lot;
    public function destroy(int $id);
}
