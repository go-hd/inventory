<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Palette
 *
 * @property int $id
 * @property int $company_id 会社ID
 * @property string $email メールアドレス
 * @property string $token ハッシュ値
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Palette whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserInvite extends Model
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
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
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
        'company',
    ];

    /**
     * 会社を取得する
     *
     * @return string
     */
    public function getCompanyAttribute()
    {
        return $this->company()
                    ->getResults();
    }

    /**
     * 招待に紐づく会社を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
