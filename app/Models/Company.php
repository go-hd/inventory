<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @property int $id ID
 * @property string $name 名称
 * @property int $main_location_id メイン拠点ID
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Location $mainLocation 拠点
 */
class Company extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
    ];

    /**
     * 拠点を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLocationsAttribute()
    {
        return $this->locations()
                    ->getResults()
                    ->makeHidden([
                        'company_id', 'location_type_id', 'company_name', 'location_type',
                        'company', 'users', 'lots', 'own_palettes', 'palettes'
                    ]);
    }

    /**
     * 会社に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
