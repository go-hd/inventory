<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LocationType
 *
 * @property int $id
 * @property string $name 名称
 * @property string|null $note 備考
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
class LocationType extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'note'
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

}
