<?php

namespace App\Repositories\StockMove;

use App\StockMove;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class StockMoveRepository
 *
 * @package App\Repositories\StockMove
 */
class StockMoveRepository implements StockMoveRepositoryInterface
{
    /**
     * @var StockMove
     */
    private $stockMove;

    public function __construct(StockMove $stockMove) {
        $this->stockMove = $stockMove;
    }

    /**
     * 在庫移動一覧を全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->stockMove->all();
    }

    /**
     * 在庫移動一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->stockMove->query();
        $company_id = $params['company_id'] ?? null;
        $brand_id = $params['brand_id'] ?? null;

        if (!is_null($company_id)) {
            $query->whereHas('brand', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            });
        } elseif (!is_null($brand_id)) {
            $query->where('brand_id', $brand_id);
        }

        return $query->get()->makeHidden(['brand']);
    }

    /**
     * 在庫移動を1件取得する
     *
     * @param int $id
     * @return StockMove
     */
    public function getOne(int $id): StockMove
    {
        return $this->stockMove->findOrFail($id);
    }

    /**
     * 在庫移動を登録する
     *
     * @param array $data
     * @return StockMove
     * @throws \Exception
     */
    public function store(array $data): StockMove
    {
        return $this->stockMove->create($data);
    }

    /**
     * 在庫移動を更新する
     *
     * @param int $id
     * @param array $data
     * @return StockMove
     * @throws \Exception
     */
    public function update(int $id, array $data): StockMove
    {
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->update($data);

        return $stockMove;
    }

    /**
     * 在庫移動を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->delete();
    }

    /**
     * 出庫タスクを取得する
     *
     * @param int $location_id
     * @param int $lot_id
     * @return StockMove[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getShippingTask(int $location_id, int $lot_id): Collection
    {
        return $this->stockMove->query()->where('shipping_location_id', $location_id)
            ->where('lot_id', $lot_id)
            ->whereNull('shipping_status')
            ->get();
    }

    /**
     * 入庫確認待ちタスクを取得する
     *
     * @param int $location_id
     * @param int $lot_id
     * @return StockMove[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getReceivingTask(int $location_id, int $lot_id): Collection
    {
        return $this->stockMove->query()->where('receiving_location_id', $location_id)
            ->whereNotNull('shipping_status')
            ->where('lot_id', $lot_id)
            ->whereNull('receiving_status')
            ->get();
    }
}
