<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @property int $id ID
 * @property string $name 名称
 * @property string $code コード
 * @property string $note 備考
 * @property Carbon $created_at 作成日
 * @property Carbon $updated_at 更新日
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
        'created_at',
        'updated_at',
    ];
}
