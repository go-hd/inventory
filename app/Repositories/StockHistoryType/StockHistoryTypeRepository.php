<?php

namespace App\Repositories\StockHistoryType;

use App\StockHistoryType;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class StockHistoryTypeRepository
 *
 * @package App\Repositories\StockHistoryType
 */
class StockHistoryTypeRepository implements StockHistoryTypeRepositoryInterface
{
    /**
     * @var StockHistoryType
     */
    private $stockHistoryType;

    public function __construct(StockHistoryType $stockHistoryType) {
        $this->stockHistoryType = $stockHistoryType;
    }

    /**
     * 在庫履歴種別一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->stockHistoryType->query();
        $company_id = $params['company_id'] ?? null;

        if (!is_null($company_id)) {
            $query->where('company_id', $company_id);
        }

        return $query->get()->makeHidden(['stock_histories']);
    }

    /**
     * 在庫履歴種別を1件取得する
     *
     * @param int $id
     * @return StockHistoryType
     */
    public function getOne(int $id): StockHistoryType
    {
        return $this->stockHistoryType->findOrFail($id)->setAppends(['locations']);
    }

    /**
     * 在庫履歴種別を登録する
     *
     * @param array $data
     * @return StockHistoryType
     * @throws \Exception
     */
    public function store(array $data): StockHistoryType
    {
        return $this->stockHistoryType->create($data);
    }

    /**
     * 在庫履歴種別を更新する
     *
     * @param int $id
     * @param array $data
     * @return StockHistoryType
     * @throws \Exception
     */
    public function update(int $id, array $data): StockHistoryType
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->update($data);

        return $stockHistoryType;
    }

    /**
     * 在庫履歴種別を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->delete();
    }
}
