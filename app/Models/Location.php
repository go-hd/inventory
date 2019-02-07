<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * @property int $id ID
 * @property string $name 名称
 * @property int $type 拠点種別
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Palette $palette パレット
 * @property Collection|Palette[] $palettes パレット
 * @property Collection|User[] $users ユーザー
 * @property Collection|ProductStock[] $productStocks 商品在庫
 * @property Collection|OrderHistory[] $orderHistories 発注履歴
 * @property Collection|DeliveryHistory[] $deliveryHistories 納品履歴
 */
class Location extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type'
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'updated_at',
        'deleted_at'
    ];

    /**
     * 拠点に紐づくパレットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function palettes()
    {
        return $this->belongsToMany(Palette::class);
    }

    /**
     * 拠点に紐づくユーザーを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * 拠点に紐づく商品在庫を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productStocks()
    {
        return $this->belongsToMany(ProductStock::class);
    }

    /**
     * 拠点に紐づく発注履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderHistories()
    {
        return $this->belongsToMany(OrderHistory::class);
    }

    /**
     * 拠点に紐づく納品履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliveryHistories()
    {
        return $this->belongsToMany(DeliveryHistory::class);
    }
}
