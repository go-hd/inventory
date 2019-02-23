<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StockMove
 *
 * @property int $id
 * @property int $shipping_id 出庫ID（在庫履歴）
 * @property int $recieving_id 入庫ID（在庫履歴）
 * @property int $location_id 相手拠点ID
 * @property int $quantity 移動個数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Location $location
 * @property-read \App\StockHistory $recievingStockHistory
 * @property-read \App\StockHistory $shippingStockHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockMove whereRecievingId($value)
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
        'shipping_id',
        'recieving_id',
        'location_id',
        'quantity'
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
        'location_name'
    ];

    /**
     * 在庫移動に紐づく出庫在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shippingStockHistory()
    {
        return $this->belongsTo(StockHistory::class, 'shipping_id');
    }

    /**
     * 在庫移動に紐づく入庫在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recievingStockHistory()
    {
        return $this->belongsTo(StockHistory::class, 'recieving_id');
    }

    /**
     * 在庫移動に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
