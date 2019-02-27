<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationType
 * @property int $id ID
 * @property string $name 名称
 * @property string $note 備考
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 */
class LocationType extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'note',
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
                        'users', 'lots', 'own_palettes', 'palettes'
                    ]);
    }

    /**
     * 拠点種別に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

}
