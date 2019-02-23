<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Palette
 *
 * @property int $id
 * @property int $location_id 拠点ID
 * @property string $type 種別
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $location_name
 * @property-read string $location_type
 * @property-read \App\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Location[] $locations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereUpdatedAt($value)
 * @mixin \Eloquent
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
