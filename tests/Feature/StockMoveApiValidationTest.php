<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockMoveApiValidationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * テスト環境をセットアップ
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    /**
     * バリデーションテスト
     *
	 * @param array   $dataList
	 * @param integer $status
	 * @param array   $messages
	 * @dataProvider  stockMoveDataProvider
     */
    public function testValidation($dataList, $status, $messages)
    {
		$response = $this->post('/stock_moves', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);
    }

    public function stockMoveDataProvider()
    {
        return [
            '成功' => [
                [
                    'shipping_id' => 1,
                    'receiving_id' => 2,
                    'location_id' => 1,
                    'quantity' => 100,
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'shipping_id' => '',
                    'receiving_id' => '',
                    'location_id' => '',
                    'quantity' => '',
                ],
                422,
                [
                    'shipping_id' => ['出庫在庫履歴を入力してください。'],
                    'receiving_id' => ['入庫在庫履歴を入力してください。'],
                    'location_id' => ['拠点を入力してください。'],
                    'quantity' => ['数量を入力してください。'],
                ],
            ],
            '失敗(integer)' => [
                [
                    'shipping_id' => 1,
                    'receiving_id' => 2,
                    'location_id' => 1,
                    'quantity' => 'test',
                ],
				422,
                [
                    'quantity' => ['数量は整数にしてください。'],
                ],
            ],
        ];
    }
}
