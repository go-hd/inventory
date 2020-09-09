<?php

namespace App\Repositories\StockMove;

use App\StockMove;
use Illuminate\Database\Eloquent\Collection;

interface StockMoveRepositoryInterface
{
    public function getAll(): Collection;
    public function getList(array $params = []): Collection;
    public function getOne(int $id): StockMove;
    public function store(array $data): StockMove;
    public function update(int $id, array $data): StockMove;
    public function destroy(int $id);
    public function getShippingTask(int $location_id, int $lot_id): Collection;
    public function getReceivingTask(int $location_id, int $lot_id): Collection;
}
