<?php

namespace App\Repositories\Brand;

use App\Brand;
use App\Location;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getListHasLots(Location $location, array $params = []);
    public function getOne(int $id): Brand;
    public function store(array $data): Brand;
    public function update(int $id, array $data): Brand;
    public function destroy(int $id);
}
