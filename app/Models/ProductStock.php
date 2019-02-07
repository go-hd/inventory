<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductStock
 * @property int $id ID
 * @property int $product_id 商品ID
 * @property int $location_id 拠点ID
 * @property Carbon $expiration_date 賞味期限
 * @property int $quantity 数量
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Product $product 商品
 * @property Location $location 拠点
 * @property Collection|OrderHistory[] $order_histories 発注履歴
 * @property Collection|DeliveryHistory[] $delivery_histories 納品履歴
 */
class ProductStock extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'location_id',
        'expiration_date',
        'quantity'
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'expiration_date',
        'created_at',
        'updated_at'
    ];

    /**
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'product_name',
        'product_code',
        'product_supplier',
        'product_maker',
        'location_name',
        'location_type'
    ];

    /**
     * 商品在庫に紐づく商品を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 商品在庫に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * 商品在庫に紐づく発注履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orderHistories()
    {
        return $this->belongsToMany(OrderHistory::class);
    }

    /**
     * 商品在庫に紐づく納品履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliveryHistories()
    {
        return $this->belongsToMany(DeliveryHistory::class);
    }

    /**
     * 商品名を取得する
     *
     * @return string
     */
    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    /**
     * 商品コードを取得する
     *
     * @return string
     */
    public function getProductCodeAttribute()
    {
        return $this->product->code;
    }

    /**
     * 商品仕入れ先を取得する
     *
     * @return string
     */
    public function getProductSupplierAttribute()
    {
        return $this->product->supplier;
    }

    /**
     * 商品メーカーを取得する
     *
     * @return string
     */
    public function getProductMakerAttribute()
    {
        return $this->product->maker;
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
