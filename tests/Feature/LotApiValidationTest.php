<?php

namespace Tests\Feature;

use App\Http\Requests\LotRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotApiValidationTest extends TestCase
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
            $data = ['location_id' => 1, 'brand_id' => 1, 'lot_number' => 'a21212121212',
                'name' => 'testName', 'jan_code' => '1313131313131', 'expiration_date' => '2019-10-10', 'ordered_at' => '2019-01-10'];
            $this->post('/lots', $data);
        }
        $request = new LotRequest();
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
                    'location_id' => 2,
                    'brand_id' => 1,
                    'lot_number' => 'b21212121212',
                    'name' => 'testName2',
                    'jan_code' => '1111111111111',
                    'expiration_date' => '2019-10-11',
                    'ordered_at' => '2019-01-11',
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'brand_id' => '',
                    'lot_number' => '',
                    'name' => '',
                    'jan_code' => '',
                    'ordered_at' => '',
                ],
                false,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'brand_id' => ['ブランドを入力してください。'],
                    'lot_number' => ['ロットナンバーを入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'jan_code' => ['JANコードを入力してください。'],
                    'ordered_at' => ['発注日を入力してください。'],
                ],
            ],
//            '失敗(unique)' => [
//                [
//                    'location_id' => 2,
//                    'brand_id' => 1,
//                    'lot_number' => 'a21212121212',
//                    'name' => 'testName2',
//                    'jan_code' => '1313131313131',
//                    'expiration_date' => '2019-10-11',
//                    'ordered_at' => '2019-01-10',
//                ],
//                false,
//                [
//                    'lot_number' => ['このロットナンバーは既に存在します。'],
//                    'jan_code' => ['このJANコードは既に存在します。'],
//                    'ordered_at' => ['この発注日は既に存在します。'],
//                ],
//                true,
//            ],
            '失敗(date)' => [
                [
                    'location_id' => 2,
                    'brand_id' => 1,
                    'lot_number' => 'b21212121212',
                    'name' => 'testName2',
                    'jan_code' => '1111111111111',
                    'expiration_date' => 'aaa',
                    'ordered_at' => 'bbb',
                ],
                false,
                [
                    'expiration_date' => ['賞味期限は正しい日付ではありません。'],
                    'ordered_at' => ['発注日は正しい日付ではありません。'],
                ],
            ],
        ];
    }
}
