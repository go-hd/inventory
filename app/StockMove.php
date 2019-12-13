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
        'recieving_location_id',
        'shipping_location_id',
        'lot_id',
        'recieving_status',
        'shipping_status',
        'quantity',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'recieving_location_id',
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
        'recieving_location',
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
    public function getRecievingLocationAttribute()
    {
        return $this->recieving_location()->getResults();
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
    public function recieving_location()
    {
        return $this->belongsTo(Location::class, 'recieving_location_id');
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

    /**
     * 出庫タスクを取得する
     *
     * @param $location_id
     * @param $lot_id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getShippingTask($location_id, $lot_id)
    {
        return self::query()
            ->where('shipping_location_id', $location_id)
            ->where('lot_id', $lot_id)
            ->whereNull('shipping_status')
            ->get();
    }

    /**
     * 入庫確認待ちタスクを取得する
     *
     * @param $location_id
     * @param $lot_id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getRecievingTask($location_id, $lot_id)
    {
        return self::query()
            ->where('recieving_location_id', $location_id)
            ->whereNotNull('shipping_status')
            ->where('lot_id', $lot_id)
            ->whereNull('recieving_status')
            ->get();
    }
}
