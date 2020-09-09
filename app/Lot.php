<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Lot
 *
 * @property int $id
 * @property int $product_id 商品ID
 * @property string $lot_number ロットナンバー
 * @property string $name 名称
 * @property \Illuminate\Support\Carbon $expiration_date 賞味期限
 * @property \Illuminate\Support\Carbon $ordered_at 発注日
 * @property boolean $ordered_quantity 発注数
 * @property int $is_ten_days_notation 発注日時期表記フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Material[] $materials
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StockHistory[] $stockHistories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereProducrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereJanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereLotNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereOrderedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lot extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'lot_number',
        'name',
        'expiration_date',
        'ordered_at',
        'is_ten_days_notation',
        'ordered_quantity',
        'is_reflected_in_stock',
        'location_id',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        //
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
        'product',
        'stock_histories',
        'ordered_at_month',
        'ordered_at_ten_days_notation',
    ];

     /**
     * 商品を取得する
     *
     * @return string
     */
    public function getProductAttribute()
    {
        return $this->product()->getResults();
    }

    /**
     * 在庫履歴を取得する
     *
     * @return string
     */
    public function getStockHistoriesAttribute()
    {
        // TODO: 在庫履歴API実装後のパラメータ調整
        return $this->stockHistories()
            ->getResults();
    }

    /**
     * 発注月を取得する
     *
     * @return string
     */
    public function getOrderedAtMonthAttribute()
    {
        // 発注日時期表記フラグがtrueの場合、時期表記に変換する
        if ($this->is_ten_days_notation) {
			return Carbon::parse($this->ordered_at)->format('n');
		} else {
            return null;
        }
    }

    public function getOrderedAtTenDaysNotationAttribute()
    {
        // 発注日時期表記フラグがtrueの場合、時期表記に変換する
        if ($this->is_ten_days_notation) {
            $day = Carbon::parse($this->ordered_at)->format('d');
            switch ($day) {
                case 1:
                    return '上旬';
                    break;
                case 11:
                    return '中旬';
                    break;
                case 21:
                    return '下旬';
                    break;
                default:
                    return null;
            }
        } else {
            return null;
        }
    }

    /**
     * 発注日時期表記フラグを取得する
     *
     * @return boolean
     */
    public function getIsTenDaysNotationAttribute($value)
    {
        return $value;
    }

    /**
     * ロットに紐づく商品を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ロットに紐づくユーザー (=ロットの登録者）を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ロットに紐づく在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    /**
     * ロットに紐づく材料を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * ロットに紐づく在庫移動を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockMoves()
    {
        return $this->hasMany(StockMove::class);
    }

    /**
     * 発注日が本日までのものを取得するscope
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrderedAtBeforeToday($query)
    {
        return $query->whereDate('ordered_at', '<=', Carbon::today());
    }

    /**
     * 在庫に未反映のものを取得するscope
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotReflectedInStock($query)
    {
        return $query->where('is_reflected_in_stock', false);
    }
}
