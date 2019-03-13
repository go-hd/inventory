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
        'company_id',
        'name',
        'note',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'company_id',
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
     * 拠点を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLocationsAttribute()
    {
        return $this->locations()
            ->getResults()
            ->makeHidden([
                'company_id', 'location_type_id', 'company_name', 'location_type',
                'users', 'lots', 'own_palettes', 'shared_palettes'
            ]);
    }

    /**
     * 拠点種別に紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

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
