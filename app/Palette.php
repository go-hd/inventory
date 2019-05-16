<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Palette
 *
 * @property int $id
 * @property int $location_id 拠点ID
 * @property string $type 種別
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $location_name
 * @property-read string $location_type
 * @property-read \App\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Location[] $locations
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
class Palette extends Model
{
    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'type',
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
        'location',
        'shared_locations',
    ];

    /**
     * 拠点を取得する
     *
     * @return string
     */
    public function getLocationAttribute()
    {
        return $this->location()
                    ->getResults()
                    ->makeHidden(['location', 'company', 'users', 'lots', 'pivot',
                            'own_palettes', 'shared_palettes', 'location_type']);
    }

    /**
     * 拠点（保管されている場所）を取得する
     *
     * @return array
     */
    public function getSharedLocationsAttribute()
    {
        $sharedLocations = $this->locations()
                                ->getResults()
                                ->makeHidden(['location', 'company', 'users', 'lots',
                                    'own_palettes', 'shared_palettes', 'pivot', 'location_type']);
        foreach ($sharedLocations as $index => $location) {
            $sharedLocations[$index]['quantity'] = $location->pivot->quantity;
        }
        return $sharedLocations;
    }

    /**
     * パレットに紐づく拠点を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * パレットに紐づく拠点を取得（パレット保管情報）
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class)->withPivot('quantity');
    }
}
