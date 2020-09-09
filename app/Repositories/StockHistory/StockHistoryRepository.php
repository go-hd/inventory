<?php

namespace App\Repositories\StockHistory;

use App\StockHistory;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class StockHistoryRepository
 *
 * @package App\Repositories\StockHistory
 */
class StockHistoryRepository implements StockHistoryRepositoryInterface
{
    /**
     * @var StockHistory
     */
    private $stockHistory;

    public function __construct(StockHistory $stockHistory) {
        $this->stockHistory = $stockHistory;
    }

    /**
     * 在庫履歴一覧を全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->stockHistory->all()->makeHidden('lot');
    }

    /**
     * 在庫履歴一覧を取得する
     *
     * @param int $location_id
     * @param int $lot_id
     * @return Collection
     */
    public function getList(int $location_id, int $lot_id): Collection
    {
        $query = $this->stockHistory->query();

        return $query->where('location_id', $location_id)->where('lot_id', $lot_id)->get();
    }

    /**
     * 在庫履歴を1件取得する
     *
     * @param int $id
     * @return StockHistory
     */
    public function getOne(int $id): StockHistory
    {
        return $this->stockHistory->findOrFail($id);
    }

    /**
     * 在庫履歴を登録する
     *
     * @param array $data
     * @return StockHistory
     * @throws \Exception
     */
    public function store(array $data): StockHistory
    {
        return $this->stockHistory->create($data);
    }

    /**
     * 在庫履歴を更新する
     *
     * @param int $id
     * @param array $data
     * @return StockHistory
     * @throws \Exception
     */
    public function update(int $id, array $data): StockHistory
    {
        $stockHistory = $this->stockHistory->findOrFail($id);
        $stockHistory->update($data);

        return $stockHistory;
    }

    /**
     * 在庫履歴を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $stockHistory = $this->stockHistory->findOrFail($id);
        $stockHistory->delete();
    }

    /**
     * 出庫タスクを取得する
     *
     * @param int $location_id
     * @param int $lot_id
     * @return StockHistory[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getShippingTask(int $location_id, int $lot_id): Collection
    {
        return $this->stockHistory->query()->where('shipping_location_id', $location_id)
            ->where('lot_id', $lot_id)
            ->whereNull('shipping_status')
            ->get();
    }

    /**
     * 入庫確認待ちタスクを取得する
     *
     * @param int $location_id
     * @param int $lot_id
     * @return StockHistory[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getReceivingTask(int $location_id, int $lot_id): Collection
    {
        return $this->stockHistory->query()->where('receiving_location_id', $location_id)
            ->whereNotNull('shipping_status')
            ->where('lot_id', $lot_id)
            ->whereNull('receiving_status')
            ->get();
    }
}
