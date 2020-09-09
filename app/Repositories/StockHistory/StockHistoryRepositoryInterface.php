<?php

namespace App\Repositories\StockHistory;

use App\StockHistory;
use Illuminate\Database\Eloquent\Collection;

interface StockHistoryRepositoryInterface
{
    public function getAll(): Collection;
    public function getList(int $location_id, int $lot_id): Collection;
    public function getOne(int $id): StockHistory;
    public function store(array $data): StockHistory;
    public function update(int $id, array $data): StockHistory;
    public function destroy(int $id);
}
