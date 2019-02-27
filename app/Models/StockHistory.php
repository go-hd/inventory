<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockHistory
 * @property int $id ID
 * @property int $location_id 拠点ID
 * @property int $lot_id ロットID
 * @property int $stock_history_type_id 在庫履歴種別ID
 * @property int $quantity 数量
 * @property string $note 備考
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Location $location 拠点
 * @property StockHistoryType $type 在庫履歴種別
 * @property Lot $lot ロット
 * @property Collection|StockMove[] $stockMoves 在庫移動
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
        'stock_history_type_name',
        'location_name',
        'lot_name',
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
