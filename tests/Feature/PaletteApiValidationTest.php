<?php

namespace Tests\Feature;

use App\Palette;
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
	 * @param array   $dataList
	 * @param integer $status
	 * @param array   $messages
	 * @param boolean $isUnique
	 * @dataProvider  paletteDataProvider
	 */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
		if ($isUnique) {
			// ユニークチェック用のデータを入れる
			$origin = factory(Palette::class)->create([
				'location_id' => 1,
				'type' => 'testType',
			]);
		}

		$response = $this->post('/palettes', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);

		if ($isUnique) {
			$response = $this->put('/palettes/' . $origin->id, $dataList);
			$response->assertStatus(200);
		}
    }

    public function paletteDataProvider()
    {
        return [
            '成功' => [
                [
                    'location_id' => 1,
                    'type' => 'testType2',
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'type' => '',
                ],
                422,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'type' => ['種別を入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'location_id' => 1,
                    'type' => 'testType',
                ],
                422,
                [
                    'location_id' => ['この拠点は既に存在します。'],
                    'type' => ['この種別は既に存在します。'],
                ],
                true,
            ],
        ];
    }
}
