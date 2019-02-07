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
        'password'
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
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
        'location_name',
        'location_type'
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
     * ユーザーに紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * 拠点名を取得する
     *
     * @return string
     */
    public function getLocationNameAttribute()
    {
        return $this->location->name;
    }

    /**
     * 拠点種別を取得する
     *
     * @return string
     */
    public function getLocationTypeAttribute()
    {
        return $this->location->type;
    }
}
