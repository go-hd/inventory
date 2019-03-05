<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Brand
 *
 * @property int $id
 * @property string $name 名称
 * @property string $code コード
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brand extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'note',
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'expiration_date',
        'created_at',
        'updated_at',
    ];

    /**
     * モデルの配列形態に追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'lots',
    ];

    /**
     * ロットを取得する
     *
     * @return string
     */
    public function getLotsAttribute()
    {
        return $this->lots()->getResults()->makeHidden(['location_name', 'location_type_name', 'location_id', 'brand_id', 'brand_name']);
    }

    /**
     * ブランドに紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
