<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Lot
 *
 * @property int $id
 * @property int $location_id 拠点ID
 * @property int $brand_id ブランドID
 * @property string $lot_number ロットナンバー
 * @property string $name 名称
 * @property string $jan_code JANコード
 * @property \Illuminate\Support\Carbon $expiration_date 賞味期限
 * @property \Illuminate\Support\Carbon $ordered_at 発注日
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Brand $brand
 * @property-read string $brand_name
 * @property-read string $location_name
 * @property-read string $location_type_name
 * @property-read \App\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Recipe[] $recipes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StockHistory[] $stockHistories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereJanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereLotNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereOrderedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lot extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'brand_id',
        'lot_number',
        'name',
        'jan_code',
        'expiration_date',
        'ordered_at',
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'expiration_date',
        'ordered_at',
        'created_at',
        'updated_at',
    ];

    /**
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'location_name',
        'location_type_name',
        'brand_name',
    ];

    /**
     * ロットに紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * ロットに紐づくブランドを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * ロットに紐づく在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    /**
     * ロットに紐づくレシピを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
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
     * 拠点種別名を取得する
     *
     * @return string
     */
    public function getLocationTypeNameAttribute()
    {
        return $this->location->type->name;
    }

    /**
     * ブランド名を取得する
     *
     * @return string
     */
    public function getBrandNameAttribute()
    {
        return $this->brand->name;
    }
}
