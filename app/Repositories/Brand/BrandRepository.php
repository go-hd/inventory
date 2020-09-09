<?php

namespace App\Repositories\Brand;

use App\Brand;
use App\Location;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BrandRepository
 *
 * @package App\Repositories\Brand
 */
class BrandRepository implements BrandRepositoryInterface
{
    /**
     * @var Brand
     */
    private $brand;

    public function __construct(Brand $brand) {
        $this->brand = $brand;
    }

    /**
     * ブランド一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->brand->query();

        if (!is_null($params['company_id'])) {
            $query->where('company_id', $params['company_id']);
        }

        return $query->orderBy('created_at', 'desc')->get()->makeHidden('products');
    }

    /**
     * ロットを保有しているブランド一覧を取得する
     *
     * @param Location $location
     * @param array $params
     * @return Brand[]|array|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function getListHasLots(Location $location, array $params = [])
    {
        $brands = [];
        $query = $this->brand->query()->where('company_id', $params['company_id']);

        if (!is_null($params['group_by_location'])) {
            // 拠点ごとに取得する
            $locations = $location->query()->where('company_id', $params['company_id'])->get();
            foreach ($locations as $location) {
                $query = $this->brand->query()->where('company_id', $params['company_id']);
                $brand = $query->whereHas('products', function($query) use ($location) {
                    $query->whereHas('lots', function($query) use ($location) {
                        $query->where(function($query)  use ($location) {
                            $query->where('location_id', $location->id);
                            $query->orWhereHas('stockMoves', function($query) use($location) {
                                $query->where('shipping_status', 1);
                                $query->where('receiving_location_id', $location->id);
                            });
                        });
                    });
                })->get();
                if (count($brand) !== 0) {
                    $brands[$location->id] = $brand;
                }
            }
        } else {
            $query->whereHas('products', function($query) {
                $query->whereHas('lots');
            });
            $brands = $query->orderBy('created_at', 'desc')->get();
        }

        return $brands;
    }

    /**
     * ブランドを1件取得する
     *
     * @param int $id
     * @return Brand
     */
    public function getOne(int $id): Brand
    {
        return $this->brand->findOrFail($id);
    }

    /**
     * ブランドを登録する
     *
     * @param array $data
     * @return Brand
     * @throws \Exception
     */
    public function store(array $data): Brand
    {
        return $this->brand->create($data);
    }

    /**
     * ブランドを更新する
     *
     * @param int $id
     * @param array $data
     * @return Brand
     * @throws \Exception
     */
    public function update(int $id, array $data): Brand
    {
        $brand = $this->brand->findOrFail($id);
        $brand->update($data);

        return $brand;
    }

    /**
     * ブランドを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $brand = $this->brand->findOrFail($id);
        $brand->delete();
    }
}
