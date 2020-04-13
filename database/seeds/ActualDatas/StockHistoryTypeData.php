<?php

use Carbon\Carbon;

/**
 * Class StockHistoryTypeData
 */
class StockHistoryTypeData
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
                'name' => '出荷',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => '入荷',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'name' => '棚卸し',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
