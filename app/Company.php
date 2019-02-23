<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Company
 *
 * @property int $id
 * @property string $name 名称
 * @property int|null $main_location_id メイン拠点ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $main_location_name
 * @property-read string $main_location_type
 * @property-read \App\Location|null $mainLocation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereMainLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUpdatedAt($value)
 * @mixin \Eloquent
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
