<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Material
 *
 * @property int $id
 * @property int $parent_lot_id 親ロットID
 * @property int $child_lot_id 子ロットID
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Lot $childLot
 * @property-read string $child_lot_name
 * @property-read string $parent_lot_name
 * @property-read \App\Lot $parentLot
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereChildLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereParentLotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Material whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Material extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'parent_lot_id',
        'child_lot_id',
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
        'parent_lot',
        'child_lot',
    ];

    /**
     * 親ロットを取得する
     *
     * @return string
     */
    public function getParentLotAttribute()
    {
        return $this->parentLot()->getResults()->makeHidden(['brand', 'location', 'stock_histories']);
    }

    /**
     * 子ロットを取得する
     *
     * @return string
     */
    public function getChildLotAttribute()
    {
        return $this->childLot()->getResults()->makeHidden(['brand', 'location', 'stock_histories']);
    }

    /**
     * レシピに紐づく親ロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentLot()
    {
        return $this->belongsTo(Lot::class, 'parent_lot_id');
    }

    /**
     * レシピに紐づく子ロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function childLot()
    {
        return $this->belongsTo(Lot::class, 'child_lot_id');
    }

    /**
     * 親ロット名を取得する
     *
     * @return string
     */
    public function getParentLotNameAttribute()
    {
        return $this->parentLot->name;
    }

    /**
     * 子ロット名を取得する
     *
     * @return string
     */
    public function getChildLotNameAttribute()
    {
        return $this->childLot->name;
    }
}
