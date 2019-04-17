<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StockHistoryType
 *
 * @property int $id
 * @property string $name 名前
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StockHistoryType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockHistoryType extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'note',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'company_id',
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
        'stock_histories'
    ];

    /**
     * 在庫履歴を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getStockHistoriesAttribute()
    {
        return $this->stock_histories()
            ->getResults()
            ->makeHidden([
                'stock_history_type'
            ]);
    }

    /**
     * 在庫履歴種別に紐づく在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock_histories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
