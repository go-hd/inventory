<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LocationType
 *
 * @property int $id
 * @property int $company_id 会社ID
 * @property string $email メールアドレス
 * @property string $token 認証用トークン
 * @property string $is_verified 認証済みフラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserVerification extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'email',
        'token',
        'is_verified',
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
     * 拠点種別に紐づく会社を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
