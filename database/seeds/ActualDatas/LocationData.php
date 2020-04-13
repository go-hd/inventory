<?php

use Carbon\Carbon;

/**
 * Class LocationData
 */
class LocationData
{
    /**
     * @return array
     */
    public static function getDataList()
    {
        $now = Carbon::now();

        return [
            [
                'company_id' => 1,
                'name' => 'G.O',
                'location_type_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => 'DMS',
                'location_type_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => 'FBA',
                'location_type_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => 'タイズ',
                'location_type_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => '出水紙工',
                'location_type_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => '杉原紙器',
                'location_type_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
