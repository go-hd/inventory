<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lot
 * @property int $id ID
 * @property int $location_id 拠点ID
 * @property int $brand_id ブランドID
 * @property string $lot_number ロットナンバー
 * @property string $name 名称
 * @property string $jan_code JANコード
 * @property Carbon $expiration_date 賞味期限
 * @property Carbon $ordered_at 発注日
 * @property Carbon $updated_at 更新日
 * @property Location $location 拠点
 * @property Location $brand ブランド
 * @property Collection|StockHistory[] $stockHistories 在庫履歴
 * @property Collection|Recipe[] $recipes レシピ
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
