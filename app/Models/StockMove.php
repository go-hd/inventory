<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockMove
 * @property int $id ID
 * @property int $shipping_id 出庫ID
 * @property int $recieving_id 入庫ID
 * @property int $location_id 拠点ID
 * @property int $quantity 移動個数
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property StockHistory $shippingStockHistory 出庫在庫履歴
 * @property StockHistory $recievingStockHistory 入庫在庫履歴
 * @property Location $location 拠点
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
        'quantity',
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
        'location_name',
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
