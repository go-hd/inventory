<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockHistoryApiValidationTest extends TestCase
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
	 * @dataProvider  stockHistoryDataProvider
	 */
    public function testValidation($dataList, $status, $messages)
    {
		$response = $this->post('/stock_histories', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);
    }

    public function stockHistoryDataProvider()
    {
        return [
            '成功' => [
                [
                    'location_id' => 1,
                    'lot_id' => 1,
                    'stock_history_type_id' => 1,
                    'quantity' => 100,
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'lot_id' => '',
                    'stock_history_type_id' => '',
                    'quantity' => '',
                ],
                422,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'lot_id' => ['ロットを入力してください。'],
                    'stock_history_type_id' => ['在庫履歴種別を入力してください。'],
                    'quantity' => ['数量を入力してください。'],
                ],
            ],
            '失敗(numeric)' => [
                [
                    'location_id' => 1,
                    'lot_id' => 1,
                    'stock_history_type_id' => 1,
                    'quantity' => 'test',
                ],
				422,
                [
                    'quantity' => ['数量は数字にしてください。'],
                ],
            ],
        ];
    }
}
