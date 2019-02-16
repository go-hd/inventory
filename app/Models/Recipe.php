<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Palette
 * @property int $id ID
 * @property int $parent_lot_id 親ロットID
 * @property int $child_lot_id 子ロットID
 * @property string $note 備考
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Lot $parentLot 親ロット
 * @property Lot $childLot 子ロット
 */
class Recipe extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'parent_lot_id',
        'child_lot_id',
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
        'parent_lot_name',
        'child_lot_name'
    ];

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
