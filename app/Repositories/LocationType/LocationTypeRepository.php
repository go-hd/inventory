<?php

namespace App\Repositories\LocationType;

use App\LocationType;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LocationTypeRepository
 *
 * @package App\Repositories\LocationType
 */
class LocationTypeRepository implements LocationTypeRepositoryInterface
{
    /**
     * @var LocationType
     */
    private $locationType;

    public function __construct(LocationType $locationType) {
        $this->locationType = $locationType;
    }

    /**
     * 拠点種別一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->locationType->query();

        return $query->get();
    }

    /**
     * 拠点種別を1件取得する
     *
     * @param int $id
     * @return LocationType
     */
    public function getOne(int $id): LocationType
    {
        return $this->locationType->findOrFail($id)->setAppends(['locations', 'company']);
    }

    /**
     * 拠点種別を登録する
     *
     * @param array $data
     * @return LocationType
     * @throws \Exception
     */
    public function store(array $data): LocationType
    {
        return $this->locationType->create($data);
    }

    /**
     * 拠点種別を更新する
     *
     * @param int $id
     * @param array $data
     * @return LocationType
     * @throws \Exception
     */
    public function update(int $id, array $data): LocationType
    {
        $locationType = $this->locationType->findOrFail($id);
        $locationType->update($data);

        return $locationType;
    }

    /**
     * 拠点種別を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $locationType = $this->locationType->findOrFail($id);
        $locationType->delete();
    }
}
