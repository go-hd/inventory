<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StockMove
 *
 * @property int $id
 * @property int $shipping_id 出庫ID（在庫履歴）
 * @property int $receiving_id 入庫ID（在庫履歴）
 * @property int $location_id 相手拠点ID
 * @property int $quantity 移動個数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Location $location
 * @property-read \App\StockHistory $receivingStockHistory
 * @property-read \App\StockHistory $shippingStockHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove wherereceivingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockMove extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'receiving_location_id',
        'shipping_location_id',
        'lot_id',
        'receiving_status',
        'shipping_status',
        'quantity',
        'is_from_material',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'receiving_location_id',
        'shipping_location_id',
        'lot_id',
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
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'shipping_location',
        'receiving_location',
        'lot',
    ];

    /**
     * 出庫拠点を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getShippingLocationAttribute()
    {
        return $this->shipping_location()->getResults();
    }

    /**
     * 入庫拠点を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getreceivingLocationAttribute()
    {
        return $this->receiving_location()->getResults();
    }

    /**
     * ロットを取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLotAttribute()
    {
        return $this->lot()->getResults();
    }

    /**
     * 在庫移動に紐づく出庫拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping_location()
    {
        return $this->belongsTo(Location::class, 'shipping_location_id');
    }

    /**
     * 在庫移動に紐づく入庫拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiving_location()
    {
        return $this->belongsTo(Location::class, 'receiving_location_id');
    }

    /**
     * 在庫移動に紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
