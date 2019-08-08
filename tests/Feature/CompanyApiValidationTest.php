<?php

namespace Tests\Feature;

use App\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyApiValidationTest extends TestCase
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
	 * @dataProvider  companyDataProvider
	 */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
        if ($isUnique) {
			// ユニークチェック用のデータを入れる
			$origin = factory(Company::class)->create([
				'name' => 'testName',
				'company_code' => 'testCode',
			]);
        }

		$response = $this->post('/companies', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);

		if ($isUnique) {
			$response = $this->put('/companies/' . $origin->id, $dataList);
			$response->assertStatus(200);
		}
    }

    public function companyDataProvider()
    {
        return [
            '成功' => [
                [
                    'name' => 'testName2',
                    'company_code' => 'testCode2',
                ],
				200,
                [],
            ],
            '失敗(required)' => [
                [
                    'name' => '',
                    'company_code' => '',
                ],
				422,
                [
                    'name' => ['名称を入力してください。'],
                    'company_code' => ['会社コードを入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'name' => 'testName',
                    'company_code' => 'testCode',
                ],
				422,
                [
                    'name' => ['この名称は既に存在します。'],
                    'company_code' => ['この会社コードは既に存在します。'],
                ],
                true,
            ],
        ];
    }
}
