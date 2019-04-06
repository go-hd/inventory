<?php

namespace Tests\Feature;

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
	 * @param array   $dataList
	 * @param integer $status
	 * @param array   $messages
     * @dataProvider lotDataProvider
     */
    public function testValidation($dataList, $status, $messages)
    {
		$response = $this->post('/locations', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);
    }

    public function lotDataProvider()
    {
        return [
            '成功' => [
                [
                    'company_id' => 1,
                    'name' => 'testName',
                    'location_type_id' => 1,
                ],
				200,
                [],
            ],
            '失敗(required)' => [
                [
                    'company_id' => '',
                    'name' => '',
                    'location_type_id' => '',
                ],
                422,
                [
                    'company_id' => ['会社を入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'location_type_id' => ['拠点種別を入力してください。'],
                ],
            ],
        ];
    }
}
