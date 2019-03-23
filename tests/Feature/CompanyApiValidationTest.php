<?php

namespace Tests\Feature;

use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyApiValidationTest extends TestCase
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
            $data = ['name' => 'testName'];
            $this->post('/companies', $data);
        }
        $request = new CompanyRequest();
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
                    'name' => 'testName2',
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'name' => '',
                ],
                false,
                [
                    'name' => ['名称を入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'name' => 'testName',
                ],
                false,
                [
                    'name' => ['この名称は既に存在します。'],
                ],
                true,
            ],
        ];
    }
}
