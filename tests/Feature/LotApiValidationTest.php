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
            $origin = factory(Lot::class)->create([
                'product_id' => 1,
                'lot_number' => 'a21212121212',
                'name' => 'testName',
                'expiration_date' => '2019-10-10',
                'ordered_at' => '2019-01-10',
                'ordered_quantity' => 100,
            ]);
        }

        $response = $this->post('/lots', $dataList);
        $response
            ->assertStatus($status)
            ->assertJson($messages);

        if ($isUnique) {
            $response = $this->put('/lots/' . $origin->id, $dataList);
            $response->assertStatus(200);
        }
    }

    public function lotDataProvider()
    {
        return [
            '成功' => [
                [
                    'product_id' => 1,
                    'lot_number' => 'b21212121212',
                    'name' => 'testName2',
                    'expiration_date' => '2019-10-11',
                    'ordered_at' => '2019-01-11',
                    'ordered_quantity' => 100,
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'product_id' => '',
                    'lot_number' => '',
                    'name' => '',
                    'ordered_at' => '',
                    'ordered_quantity' => '',
                ],
                422,
                [
                    'product_id' => ['商品を入力してください。'],
                    'lot_number' => ['ロットナンバーを入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'ordered_at' => ['発注日を入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'product_id' => 1,
                    'lot_number' => 'a21212121212',
                    'name' => 'testName2',
                    'expiration_date' => '2019-10-11',
                    'ordered_at' => '2019-01-10',
                    'ordered_quantity' => 100,
                ],
                422,
                [
                    'product_id' => ['この商品は既に存在します。'],
                    'lot_number' => ['このロットナンバーは既に存在します。'],
                    'ordered_at' => ['この発注日は既に存在します。'],
                ],
                true,
            ],
            '失敗(date)' => [
                [
                    'product_id' => 2,
                    'lot_number' => 'b21212121212',
                    'name' => 'testName2',
                    'expiration_date' => 'aaa',
                    'ordered_at' => 'bbb',
                    'ordered_quantity' => 100,
                ],
                422,
                [
                    'expiration_date' => ['賞味期限は正しい日付ではありません。'],
                    'ordered_at' => ['発注日は正しい日付ではありません。'],
                ],
            ],
            '失敗(int)' => [
                [
                    'product_id' => 2,
                    'lot_number' => 'b21212121212',
                    'name' => 'testName2',
                    'expiration_date' => '2019-10-11',
                    'ordered_at' => '2019-01-10',
                    'ordered_quantity' => 'test',
                ],
                422,
                [
                   'ordered_quantity' => ['発注数は整数にしてください。'],
                ],
            ],
        ];
    }
}
