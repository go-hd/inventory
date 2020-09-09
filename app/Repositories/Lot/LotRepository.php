<?php

namespace App\Repositories\Lot;

use App\Lot;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LotRepository
 *
 * @package App\Repositories\Lot
 */
class LotRepository implements LotRepositoryInterface
{
    /**
     * @var Lot
     */
    private $lot;

    public function __construct(Lot $lot) {
        $this->lot = $lot;
    }

    /**
     * ロット一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $company_id = $params['company_id'] ?? null;
        $product_id = $params['product_id'] ?? null;
        $query = $this->lot->query()->orderBy('created_at', 'desc');

        // 会社にひもづくロットを取得
        if (!is_null($company_id)) {
            $lots = $query->whereHas('product', function ($query) use ($company_id) {
                $query->whereHas('brand', function ($query) use ($company_id) {
                    $query->where('company_id', $company_id);
                });
            })->get();
        // 商品にひもづくロットを取得
        } elseif (!is_null($product_id)) {
            $lots = $query->where('product_id', $product_id)->get();
        // 全ロット取得
        } else {
            $lots = $query->get();
        }

        return $lots->makeHidden(['stock_histories', 'product']);
    }

    /**
     * ロットを1件取得する
     *
     * @param int $id
     * @return Lot
     */
    public function getOne(int $id): Lot
    {
        return $this->lot->findOrFail($id);
    }

    /**
     * ロットを登録する
     *
     * @param array $data
     * @return Lot
     * @throws \Exception
     */
    public function store(array $data): Lot
    {
        return $this->lot->create($data);
    }

    /**
     * ロットを更新する
     *
     * @param int $id
     * @param array $data
     * @return Lot
     * @throws \Exception
     */
    public function update(int $id, array $data): Lot
    {
        $lot = $this->lot->findOrFail($id);
        $lot->update($data);

        return $lot;
    }

    /**
     * ロットを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $lot = $this->lot->findOrFail($id);
        $lot->delete();
    }
}
