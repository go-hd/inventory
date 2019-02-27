<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @property int $id ID
 * @property int $location_id 拠点ID
 * @property string $name 名称
 * @property string $email メールアドレス
 * @property string $password パスワード
 * @property string $remember_token トークン
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
 * @property Location $location 拠点
 */
class User extends Authenticatable
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'name',
        'email',
        'password',
        'level',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'location_id',
        'password',
        'remember_token',
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
        'location',
        'company',
    ];

    /**
     * パスワードをハッシュ化する
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * 拠点を取得する
     *
     * @return string
     */
    public function getLocationAttribute()
    {
        return $this->location()
                    ->getResults()
                    ->makeHidden([
                        'company_id', 'location_type_id', 'company_name', 'location_type',
                        'company', 'users', 'lots', 'own_palettes', 'palettes'
                    ]);
    }

    /**
     * 会社を取得する
     *
     * @return string
     */
    public function getCompanyAttribute()
    {
        return $this->location()->getResults()->company;
    }

    /**
     * ユーザーに紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
