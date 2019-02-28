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
        'name',
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

}
