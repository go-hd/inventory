<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @property int $id ID
 * @property string $name 名称
 * @property string $code 商品コード
 * @property string $supplier 仕入れ先
 * @property string $maker メーカー
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Collection|OrderHistory[] $productStocks 商品在庫
 */
class Product extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'supplier',
        'maker'
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
     * 商品に紐づく商品在庫を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productStocks()
    {
        return $this->belongsToMany(ProductStock::class);
    }
}
