<?php

namespace Tests\Feature;

use App\Brand;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandApiValidationTest extends TestCase
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
	 * @dataProvider  brandDataProvider
	 */
    public function testValidation($dataList, $status, $messages)
    {
		$response = $this->post('/brands', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);
    }

    public function brandDataProvider()
    {
        return [
            '成功' => [
                [
                    'name' => 'testName',
                    'code' => 'testCode',
                ],
				200,
                [],
            ],
            '失敗(required)' => [
                [
                    'name' => '',
                    'code' => '',
                ],
				422,
                [
                    'name' => ['名称を入力してください。'],
                    'code' => ['コードを入力してください。'],
                ],
            ],
        ];
    }
}
