<?php

namespace Tests\Feature;

use App\Lot;
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
     * @param array   $dataList
     * @param integer $status
     * @param array   $messages
     * @param boolean $isUnique
     * @dataProvider  lotDataProvider
     */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
        if ($isUnique) {
            // ユニークチェック用のデータを入れる
            factory(Lot::class)->create([
                'location_id' => 1,
                'brand_id' => 1,
                'lot_number' => 'a21212121212',
                'name' => 'testName',
                'jan_code' => '1313131313131',
                'expiration_date' => '2019-10-10',
                'ordered_at' => '2019-01-10'
            ]);
        }

        $response = $this->post('/lots', $dataList);
        $response
            ->assertStatus($status)
            ->assertJson($messages);
    }

    public function lotDataProvider()
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
                200,
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
                422,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'brand_id' => ['ブランドを入力してください。'],
                    'lot_number' => ['ロットナンバーを入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'jan_code' => ['JANコードを入力してください。'],
                    'ordered_at' => ['発注日を入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'location_id' => 2,
                    'brand_id' => 1,
                    'lot_number' => 'a21212121212',
                    'name' => 'testName2',
                    'jan_code' => '1313131313131',
                    'expiration_date' => '2019-10-11',
                    'ordered_at' => '2019-01-10',
                ],
                422,
                [
                    'lot_number' => ['このロットナンバーは既に存在します。'],
                    'jan_code' => ['このJANコードは既に存在します。'],
                    'ordered_at' => ['この発注日は既に存在します。'],
                ],
                true,
            ],
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
                422,
                [
                    'expiration_date' => ['賞味期限は正しい日付ではありません。'],
                    'ordered_at' => ['発注日は正しい日付ではありません。'],
                ],
            ],
        ];
    }
}
