<?php

namespace App\Repositories\Product;

use App\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Product;
    public function store(array $data): Product;
    public function update(int $id, array $data): Product;
    public function destroy(int $id);
}
