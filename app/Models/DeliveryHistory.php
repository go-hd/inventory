<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryHistory
 * @property int $id ID
 * @property int $product_stock_id 商品在庫ID
 * @property int $location_id 拠点ID
 * @property int $quantity 数量
 * @property string $note 備考
 * @property Carbon $delivery_at 納品日
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property ProductStock $productStock 商品在庫
 * @property Location $location 拠点
 */
class DeliveryHistory extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'product_stock_id',
        'location_id',
        'quantity',
        'note',
        'delivery_at'
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'delivery_at',
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
        'product_stock_expiration_date',
        'product_stock_quantity',
        'location_name',
        'location_type'
    ];

    /**
     * 納品履歴に紐づく商品在庫を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    /**
     * 納品履歴に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * 商品名を取得する
     *
     * @return string
     */
    public function getProductNameAttribute()
    {
        return $this->productStock->product->name;
    }

    /**
     * 商品コードを取得する
     *
     * @return string
     */
    public function getProductCodeAttribute()
    {
        return $this->productStock->product->code;
    }

    /**
     * 商品仕入れ先を取得する
     *
     * @return string
     */
    public function getProductSupplierAttribute()
    {
        return $this->productStock->product->supplier;
    }

    /**
     * 商品メーカーを取得する
     *
     * @return string
     */
    public function getProductMakerAttribute()
    {
        return $this->productStock->product->maker;
    }

    /**
     * 商品在庫賞味期限を取得する
     *
     * @return string
     */
    public function getProductStockExpirationDateAttribute()
    {
        return $this->productStock->expiration_date;
    }

    /**
     * 商品在庫数量を取得する
     *
     * @return string
     */
    public function getProductStockQuantityAttribute()
    {
        return $this->productStock->quantity;
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
