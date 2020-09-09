<?php

namespace App\Repositories\StockHistoryType;

use App\StockHistoryType;
use Illuminate\Database\Eloquent\Collection;

interface StockHistoryTypeRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): StockHistoryType;
    public function store(array $data): StockHistoryType;
    public function update(int $id, array $data): StockHistoryType;
    public function destroy(int $id);
}
