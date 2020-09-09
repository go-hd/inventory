<?php

namespace App\Repositories\Company;

use App\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function getList(array $params = []): Collection;
    public function getOne(int $id): Company;
    public function getByCode(string $code): Company;
    public function store(array $data): Company;
    public function update(int $id, array $data): Company;
    public function destroy(int $id);
}
