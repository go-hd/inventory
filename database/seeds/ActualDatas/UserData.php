<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserData
 */
class UserData
{
    /**
     * @return array
     */
    public static function getDataList()
    {
        $now = Carbon::now();

        return [
            [
                'location_id' => 1,
                'name' => 'G.Oユーザー',
                'email' => 'user1@go.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'location_id' => 2,
                'name' => 'DMSユーザー',
                'email' => 'user1@dms.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'location_id' => 3,
                'name' => 'FBAユーザー',
                'email' => 'user1@fba.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'location_id' => 4,
                'name' => 'タイズユーザー',
                'email' => 'user1@taizu.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'location_id' => 5,
                'name' => '出水紙工ユーザー',
                'email' => 'user1@izumi-shikou.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'location_id' => 6,
                'name' => '杉原紙器',
                'email' => 'user1@sugihara-shiki.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
