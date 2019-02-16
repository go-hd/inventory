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
        'main_location_id'
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'main_location_name',
        'main_location_type'
    ];

    /**
     * 会社に紐づくメイン拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mainLocation()
    {
        return $this->belongsTo(Location::class, 'main_location_id');
    }

    /**
     * メイン拠点名を取得する
     *
     * @return string
     */
    public function getMainLocationNameAttribute()
    {
        return $this->mainLocation->name;
    }

    /**
     * メイン拠点種別を取得する
     *
     * @return string
     */
    public function getMainLocationTypeAttribute()
    {
        return $this->mainLocation->type->name;
    }
}
