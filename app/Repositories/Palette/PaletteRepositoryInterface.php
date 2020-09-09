<?php

namespace App\Repositories\Palette;

use App\Palette;
use Illuminate\Database\Eloquent\Collection;

interface PaletteRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Palette;
    public function store(array $data): Palette;
    public function update(int $id, array $data): Palette;
    public function destroy(int $id);
    public function move(int $palette_id, int $location_id, int $quantity): Palette;
}
