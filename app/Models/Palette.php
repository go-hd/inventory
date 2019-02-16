<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Palette
 * @property int $id ID
 * @property int $location_id 拠点ID
 * @property string $type 種別
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Location $location 拠点
 * @property Collection|Location[] $locations 拠点
 */
class Palette extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'type'
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
        'location_name',
        'location_type'
    ];

    /**
     * パレットに紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * パレットに紐づく拠点を取得（パレット保管情報）
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * 拠点名を取得する
     *
     * @return string
     */
    public function getLocationNameAttribute()
    {
        return $this->location->name;
    }

    /**
     * 拠点種別を取得する
     *
     * @return string
     */
    public function getLocationTypeAttribute()
    {
        return $this->location->type;
    }
}
