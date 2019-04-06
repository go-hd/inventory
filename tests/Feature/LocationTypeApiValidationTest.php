<?php

namespace Tests\Feature;

use App\LocationType;
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
	 * @param array   $dataList
	 * @param integer $status
	 * @param array   $messages
	 * @param boolean $isUnique
	 * @dataProvider  locationTypeDataProvider
	 */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
		if ($isUnique) {
			// ユニークチェック用のデータを入れる
			$origin = factory(LocationType::class)->create([
				'company_id' => 1,
				'name' => 'testName',
			]);
		}

		$response = $this->post('/location_types', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);

		if ($isUnique) {
			$response = $this->put('/location_types/' . $origin->id, $dataList);
			$response->assertStatus(200);
		}
    }

    public function locationTypeDataProvider()
    {
        return [
            '成功' => [
                [
                    'company_id' => 1,
                    'name' => 'testName2',
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'company_id' => '',
                    'name' => '',
                ],
				422,
                [
                    'company_id' => ['会社を入力してください。'],
                    'name' => ['名称を入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'company_id' => 1,
                    'name' => 'testName',
                ],
				422,
                [
                    'company_id' => ['この会社は既に存在します。'],
                    'name' => ['この名称は既に存在します。'],
                ],
                true,
            ],
        ];
    }
}
