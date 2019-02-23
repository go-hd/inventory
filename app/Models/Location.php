<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * @property int $id ID
 * @property int $company_id 会社ID
 * @property string $name 名称
 * @property int $location_type_id 拠点種別ID
 * @property string $location_code 拠点コード
 * @property string $location_number 拠点ナンバー
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property LocationType $type 拠点種別
 * @property Company $company 会社
 * @property Collection|Palette[] $palettes パレット
 * @property Collection|User[] $users ユーザー
 * @property Collection|Lot[] $lots ロット
 * @property Collection|stockHistory[] $stockHistories 在庫履歴
 * @property Collection|stockMove[] $stockMoves 在庫移動
 */
class Location extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'location_type_id',
        'location_code',
        'location_number'
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
        'company_name',
        'location_type_name'
    ];

    /**
     * 拠点に紐づく種別を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }

    /**
     * 拠点に紐づく会社を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 拠点に紐づくユーザーを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * 拠点に紐づくパレットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palettes()
    {
        return $this->hasMany(Palette::class);
    }

    /**
     * 拠点に紐づくロットを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    /**
     * 拠点に紐づく在庫履歴を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    /**
     * 拠点に紐づく在庫移動を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockMoves()
    {
        return $this->hasMany(StockMove::class);
    }

    /**
     * 会社名を取得する
     *
     * @return string
     */
    public function getCompanyNameAttribute()
    {
        return $this->company->name;
    }

    /**
     * 会社名を取得する
     *
     * @return string
     */
    public function getLocationTypeNameAttribute()
    {
        return $this->type->name;
    }
}
