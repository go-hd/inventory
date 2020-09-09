<?php

namespace App\Repositories\Palette;

use App\Palette;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PaletteRepository
 *
 * @package App\Repositories\Palette
 */
class PaletteRepository implements PaletteRepositoryInterface
{
    /**
     * @var Palette
     */
    private $palette;

    public function __construct(Palette $palette) {
        $this->palette = $palette;
    }

    /**
     * パレット一覧を取得する
     *
     * @param array $params
     * @return Collection
     */
    public function getList(array $params = []): Collection
    {
        $query = $this->palette->query();
        $company_id = $params['company_id'] ?? null;

        if (!is_null($company_id)) {
            $query->whereHas('location', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->orderBy('created_at', 'desc');
        }

        return $query->get()->makeHidden('shared_locations');
    }

    /**
     * パレットを1件取得する
     *
     * @param int $id
     * @return Palette
     */
    public function getOne(int $id): Palette
    {
        return $this->palette->findOrFail($id);
    }

    /**
     * パレットを登録する
     *
     * @param array $data
     * @return Palette
     * @throws \Exception
     */
    public function store(array $data): Palette
    {
        return $this->palette->create($data);
    }

    /**
     * パレットを更新する
     *
     * @param int $id
     * @param array $data
     * @return Palette
     * @throws \Exception
     */
    public function update(int $id, array $data): Palette
    {
        $palette = $this->palette->findOrFail($id);
        $palette->update($data);

        return $palette;
    }

    /**
     * パレットを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $palette = $this->palette->findOrFail($id);
        $palette->delete();
    }

    /**
     * パレットを移動する
     *
     * @param int $palette_id
     * @param int $location_id
     * @param int $quantity
     * @return Palette
     */
    public function move(int $palette_id, int $location_id, int $quantity): Palette
    {
        $query = $this->palette->query();
        $palette = $query->findOrFail($palette_id);

        if ($palette->locations()->where('locations.id', $location_id)->exists()) {
            $palette->locations()->updateExistingPivot($location_id, ['quantity' => $quantity], false);
        } else {
            $palette->locations()->attach($location_id, ['quantity' => $quantity]);
        }

        return $palette;
    }
}
