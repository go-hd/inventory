<?php

namespace App\Repositories\Material;

use App\Material;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MaterialRepository
 *
 * @package App\Repositories\Material
 */
class MaterialRepository implements MaterialRepositoryInterface
{
    /**
     * @var Material
     */
    private $material;

    public function __construct(Material $material) {
        $this->material = $material;
    }

    /**
     * レシピ一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->material->query()->orderBy('created_at', 'desc');
        if (!is_null($params['parent_lot_id'])) {
            $query->where('parent_lot_id', $params['parent_lot_id']);
        }

        return $query->get()->makeHidden(['parent_lot', 'child_lot']);
    }

    /**
     * レシピを1件取得する
     *
     * @param int $id
     * @return Material
     */
    public function getOne(int $id): Material
    {
        return $this->material->findOrFail($id);
    }

    /**
     * レシピを登録する
     *
     * @param array $data
     * @return Material
     * @throws \Exception
     */
    public function store(array $data): Material
    {
        return $this->material->create($data);
    }

    /**
     * レシピを更新する
     *
     * @param int $id
     * @param array $data
     * @return Material
     * @throws \Exception
     */
    public function update(int $id, array $data): Material
    {
        $material = $this->material->findOrFail($id);
        $material->update($data);

        return $material;
    }

    /**
     * レシピを一括更新する
     *
     * @param array $materials
     * @param array $deleted_ids
     */
    public function updateMulti(array $materials, array $deleted_ids = [])
    {
        foreach ($materials as $material) {
            $targetMaterial = $this->material->where('parent_lot_id', $material['parent_lot_id'])
                ->where('child_lot_id', $material['child_lot_id'])->first();
            if (empty($targetMaterial)) {
                $this->material->create($material);
            } else {
                $targetMaterial->update($material);
            }
        }
        foreach ($deleted_ids as $deleted_id) {
            $this->material->findOrFail($deleted_id)->delete();
        }
    }

    /**
     * レシピを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $material = $this->material->findOrFail($id);
        $material->delete();
    }
}
