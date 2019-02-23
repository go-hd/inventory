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
 * @property-read string $location_name
 * @property-read string $lot_name
 * @property-read string $stock_history_type_name
 * @property-read \App\Location $location
 * @property-read \App\Lot $lot
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StockMove[] $stockMoves
 * @property-read \App\StockHistoryType $type
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
        'note'
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
        'stock_history_type_name',
        'location_name',
        'lot_name'
    ];

    /**
     * 在庫履歴に紐づく在庫履歴種別を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(StockHistoryType::class);
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
     * 在庫履歴に紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    /**
     * 在庫履歴に紐づく在庫移動を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockMoves()
    {
        return $this->hasMany(StockMove::class);
    }

    /**
     * 在庫履歴種別名を取得する
     *
     * @return string
     */
    public function getStockHistoryTypeNameAttribute()
    {
        return $this->type->name;
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
     * ロット名を取得する
     *
     * @return string
     */
    public function getLotNameAttribute()
    {
        return $this->lot->name;
    }

}
