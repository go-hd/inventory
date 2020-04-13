<?php

use Carbon\Carbon;

/**
 * Class LocationTypeData
 */
class LocationTypeData
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
                'name' => '自社',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => '倉庫会社',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
