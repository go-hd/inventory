<?php

namespace Tests\Feature;

use App\Lot;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiValidationTest extends TestCase
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
     * @dataProvider  lotDataProvider
     */
    public function testValidation($dataList, $status, $messages)
    {
        $response = $this->post('/products', $dataList);
        $response
            ->assertStatus($status)
            ->assertJson($messages);
    }

    public function lotDataProvider()
    {
        return [
            '成功' => [
                [
                    'brand_id' => 1,
                    'jan_code' => '1111111111111',
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'brand_id' => '',
                    'jan_code' => '',
                ],
                422,
                [
                    'brand_id' => ['ブランドを入力してください。'],
                    'jan_code' => ['JANコードを入力してください。'],
                ],
            ],
        ];
    }
}
