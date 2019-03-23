<?php

namespace Tests\Feature;

use App\Http\Requests\StockMoveRequest;
use Illuminate\Support\Facades\Validator;
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
     * @param array $dataList
     * @param boolean $expect
     * @param array $messages
     * @dataProvider brandDataProvider
     */
    public function testValidation($dataList, $expect, $messages)
    {
        $request = new StockMoveRequest();
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
                    'shipping_id' => 1,
                    'recieving_id' => 2,
                    'location_id' => 1,
                    'quantity' => 100,
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'shipping_id' => '',
                    'recieving_id' => '',
                    'location_id' => '',
                    'quantity' => '',
                ],
                false,
                [
                    'shipping_id' => ['出庫在庫履歴を入力してください。'],
                    'recieving_id' => ['入庫在庫履歴を入力してください。'],
                    'location_id' => ['拠点を入力してください。'],
                    'quantity' => ['数量を入力してください。'],
                ],
            ],
            '失敗(integer)' => [
                [
                    'shipping_id' => 1,
                    'recieving_id' => 2,
                    'location_id' => 1,
                    'quantity' => 'test',
                ],
                false,
                [
                    'quantity' => ['数量は整数にしてください。'],
                ],
            ],
        ];
    }
}
