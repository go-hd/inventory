<?php

namespace App\Repositories\Company;

use App\Company;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CompanyRepository
 *
 * @package App\Repositories\Company
 */
class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var Company
     */
    private $company;

    public function __construct(Company $company) {
        $this->company = $company;
    }

    /**
     * 会社一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->company->query();

        if (!is_null($params)) {
            $name = $params['name'];
            $query->where('name', 'LIKE', "%$name%");
        }

        return $query->get();
    }

    /**
     * 会社を1件取得する
     *
     * @param int $id
     * @return Company
     */
    public function getOne(int $id): Company
    {
        return $this->company->findOrFail($id)->setAppends(['locations']);
    }

    /**
     * コードにひもづく会社を1件取得する
     *
     * @param string $code
     * @return Company
     */
    public function getByCode(string $code): Company
    {
        return $this->company->query()->where('company_code', $code)->first();
    }

    /**
     * 会社を登録する
     *
     * @param array $data
     * @return Company
     * @throws \Exception
     */
    public function store(array $data): Company
    {
        return $this->company->create($data);
    }

    /**
     * 会社を更新する
     *
     * @param int $id
     * @param array $data
     * @return Company
     * @throws \Exception
     */
    public function update(int $id, array $data): Company
    {
        $company = $this->company->findOrFail($id);
        $company->update($data);

        return $company;
    }

    /**
     * 会社を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $company = $this->company->findOrFail($id);
        $company->delete();
    }
}
