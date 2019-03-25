<?php

namespace Tests\Feature;

use App\Http\Requests\StockHistoryRequest;
use Illuminate\Support\Facades\Validator;
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
     * @param array $dataList
     * @param boolean $expect
     * @param array $messages
     * @dataProvider brandDataProvider
     */
    public function testValidation($dataList, $expect, $messages)
    {
        $request = new StockHistoryRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        // バリデーション結果が正しいか確認
        $this->assertEquals($expect, $result);
        $result_messages = $validator->errors()->toArray();
        // エラーメッセージが正しいか確認
        foreach ($messages as $key => $value) {
            $this->assertEquals($value, $result_messages[$key]);
        }
    }

    public function brandDataProvider()
    {
        return [
            '成功' => [
                [
                    'location_id' => 1,
                    'lot_id' => 1,
                    'stock_history_type_id' => 1,
                    'quantity' => 100,
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'lot_id' => '',
                    'stock_history_type_id' => '',
                    'quantity' => '',
                ],
                false,
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
                false,
                [
                    'quantity' => ['数量は数字にしてください。'],
                ],
            ],
        ];
    }
}
