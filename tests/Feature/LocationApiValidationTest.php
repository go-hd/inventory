<?php

namespace Tests\Feature;

use App\Http\Requests\LocationRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationApiValidationTest extends TestCase
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
        // ユニークチェック用のデータを入れる
        $data = ['name' => 'testName'];
        $this->post('/locations', $data);

        $request = new LocationRequest();
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
                    'company_id' => 1,
                    'name' => 'testName',
                    'location_type_id' => 1,
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'company_id' => '',
                    'name' => '',
                    'location_type_id' => '',
                ],
                false,
                [
                    'company_id' => ['会社を入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'location_type_id' => ['拠点種別を入力してください。'],
                ],
            ],
        ];
    }
}
