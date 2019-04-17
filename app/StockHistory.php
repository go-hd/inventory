<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StockHistory
 *
 * @property int $id
 * @property int $location_id 相手拠点ID
 * @property int $lot_id ロットID
 * @property int $stock_history_type_id 在庫履歴種別ID
 * @property int $quantity 数量
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Location $location
 * @property-read \App\Lot $lot
 * @property-read \App\StockHistoryType $stock_history_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereStockHistoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockHistory extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'lot_id',
        'stock_history_type_id',
        'quantity',
        'note',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'location_id',
        'lot_id',
        'stock_history_type_id',
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
        'lot',
        'location',
        'stock_history_type',
    ];

    /**
     * ロットを取得する
     *
     * @return string
     */
    public function getLotAttribute()
    {
        return $this->lot()->getResults()->makeHidden(['stock_histories', 'location_name', 'brand', 'location']);
    }

    /**
     * 拠点を取得する
     *
     * @return string
     */
    public function getLocationAttribute()
    {
        return $this->location()->getResults()->makeHidden(
            [
                'company', 'location_type', 'users', 'lots', 'own_palettes', 'shared_palettes'
            ]
        );
    }

    /**
     * 在庫履歴種別を取得する
     *
     * @return string
     */
    public function getStockHistoryTypeAttribute()
    {
        return $this->stock_history_type()->getResults()->makeHidden(['company', 'company_id', 'stock_histories']);
    }


    /**
     * 在庫履歴に紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * 在庫履歴に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * 在庫履歴に紐づく在庫履歴種別を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock_history_type()
    {
        return $this->belongsTo(StockHistoryType::class);
    }
}
