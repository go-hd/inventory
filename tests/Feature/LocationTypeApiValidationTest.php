<?php

namespace Tests\Feature;

use App\Http\Requests\LocationTypeRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTypeApiValidationTest extends TestCase
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
     * @param boolean $isUnique
     * @dataProvider brandDataProvider
     */
    public function testValidation($dataList, $expect, $messages, $isUnique=false)
    {
        if ($isUnique) {
            // ユニークチェック用のデータを入れる
            $data = ['company_id' => 1, 'name' => 'testName'];
            $this->post('/location_types', $data);
        }
        $request = new LocationTypeRequest();
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
                    'name' => 'testName2',
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'company_id' => '',
                    'name' => '',
                ],
                false,
                [
                    'company_id' => ['会社を入力してください。'],
                    'name' => ['名称を入力してください。'],
                ],
            ],
//            '失敗(unique)' => [
//                [
//                    'company_id' => 1,
//                    'name' => 'testName',
//                ],
//                false,
//                [
//                    'company_id' => ['この会社は既に存在します。'],
//                    'name' => ['この名称は既に存在します。'],
//                ],
//                true,
//            ],
        ];
    }
}
