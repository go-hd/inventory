<?php

namespace Tests\Feature;

use App\Material;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialApiValidationTest extends TestCase
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
	 * @dataProvider  materialDataProvider
	 */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
		if ($isUnique) {
			// ユニークチェック用のデータを入れる
			$origin = factory(Material::class)->create([
				'parent_lot_id' => 1,
				'child_lot_id' => 2,
			]);
		}

		$response = $this->post('/materials', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);

		if ($isUnique) {
			$response = $this->put('/materials/' . $origin->id, $dataList);
			$response->assertStatus(200);
		}
    }

    public function materialDataProvider()
    {
        return [
            '成功' => [
                [
                    'parent_lot_id' => 3,
                    'child_lot_id' => 4,
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'parent_lot_id' => '',
                    'child_lot_id' => '',
                ],
				422,
                [
                    'parent_lot_id' => ['親ロットを入力してください。'],
                    'child_lot_id' => ['子ロットを入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'parent_lot_id' => 1,
                    'child_lot_id' => 2,
                ],
				422,
                [
                    'parent_lot_id' => ['この親ロットは既に存在します。'],
                    'child_lot_id' => ['この子ロットは既に存在します。'],
                ],
                true,
            ],
        ];
    }
}
