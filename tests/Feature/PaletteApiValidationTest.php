<?php

namespace Tests\Feature;

use App\Http\Requests\PaletteRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaletteApiValidationTest extends TestCase
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
            $data = [
                'location_id' => 1,
                'type' => 'testType',
            ];
            $this->post('/palettes', $data);
        }
        $request = new PaletteRequest();
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
                    'type' => 'testType2',
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'type' => '',
                ],
                false,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'type' => ['種別を入力してください。'],
                ],
            ],
//            '失敗(unique)' => [
//                [
//                    'location_id' => 1,
//                    'type' => 'testType',
//                ],
//                false,
//                [
//                    'location_id' => ['この拠点は既に存在します。'],
//                    'type' => ['この種別は既に存在します。'],
//                ],
//                true,
//            ],
        ];
    }
}
