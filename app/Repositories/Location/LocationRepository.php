<?php

namespace App\Repositories\Location;

use App\Location;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LocationRepository
 *
 * @package App\Repositories\Location
 */
class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @var Location
     */
    private $location;

    public function __construct(Location $location) {
        $this->location = $location;
    }

    /**
     * 拠点一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->location->query();

        if (!is_null($params['company_id'])) {
            $query->where('company_id', $params['company_id']);
        }

        return $query->get()->makeHidden(['users', 'lots', 'own_palettes', 'shared_palettes']);
    }

    /**
     * 拠点を1件取得する
     *
     * @param int $id
     * @return Location
     */
    public function getOne(int $id): Location
    {
        return $this->location->findOrFail($id);
    }

    /**
     * 拠点を登録する
     *
     * @param array $data
     * @return Location
     * @throws \Exception
     */
    public function store(array $data): Location
    {
        return $this->location->create($data);
    }

    /**
     * 拠点を更新する
     *
     * @param int $id
     * @param array $data
     * @return Location
     * @throws \Exception
     */
    public function update(int $id, array $data): Location
    {
        $location = $this->location->findOrFail($id);
        $location->update($data);

        return $location;
    }

    /**
     * 拠点を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $location = $this->location->findOrFail($id);
        $location->delete();
    }
}
