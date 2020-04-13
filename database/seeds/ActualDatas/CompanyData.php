<?php

use Carbon\Carbon;

/**
 * Class CompanyData
 */
class CompanyData
{
    /**
     * @return array
     */
    public static function getDataList()
    {
        $now = Carbon::now();

        return [
            [
                'name' => 'G.Oホールディングス',
                'company_code' => 'GO',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];
    }
}
