<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * App\Brand
 *
 * @property int $id
 * @property int $company_id 会社ID
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
        'company_id',
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
        'products',
        'company',
        'has_stock_location_ids',
    ];

    /**
     * 商品を取得する
     *
     * @return string
     */
    public function getProductsAttribute()
    {
        return $this->products()->getResults()->makeHidden(['brand']);
    }

    /**
     * 会社を取得する
     *
     * @return string
     */
    public function getCompanyAttribute()
    {
        return $this->company()->getResults();
    }

    /**
     * ブランドにひもづく在庫がある拠点のIDを配列で取得する
     * 在庫サイドバーの表示出しわけに使用
     *
     * @return array $hasStockHistoryLocationIds
     */
    public function getHasStockLocationIdsAttribute()
    {
        $hasStockHistoryLocationIds = [];
        $locations = $this->company->locations;
        $products = $this->products;

        // TODO ここで在庫があるものだけ取得したいがうまくいかない・・・
        foreach ($locations as $location) {
            foreach ($products as $product) {
                $stock = $product->whereHas('lots', function($query) use($location) {
                    $query->whereHas('stockHistories', function($query) use ($location) {
                       $query->where('location_id', $location->id);
                    });
                })->first();
            }

            if (!empty($stock)) {
                $hasStockHistoryLocationIds[] = $location->id;
            }
        }

        return $hasStockHistoryLocationIds;
    }

    /**
     * ブランドに紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * ブランドに紐づく会社を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
