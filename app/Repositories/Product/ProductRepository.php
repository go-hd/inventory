<?php

namespace App\Repositories\Product;

use App\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductRepository
 *
 * @package App\Repositories\Product
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * 商品一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->product->query();
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
     * 商品を1件取得する
     *
     * @param int $id
     * @return Product
     */
    public function getOne(int $id): Product
    {
        return $this->product->findOrFail($id);
    }

    /**
     * 商品を登録する
     *
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function store(array $data): Product
    {
        return $this->product->create($data);
    }

    /**
     * 商品を更新する
     *
     * @param int $id
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function update(int $id, array $data): Product
    {
        $product = $this->product->findOrFail($id);
        $product->update($data);

        return $product;
    }

    /**
     * 商品を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
    }
}
