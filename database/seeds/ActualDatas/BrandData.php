<?php

use Carbon\Carbon;

/**
 * Class BrandData
 */
class BrandData
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
                'name' => 'Defend Future',
                'code' => 'DF',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
