<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserApiValidationTest extends TestCase
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
	 * @dataProvider  userDataProvider
	 */
    public function testValidation($dataList, $status, $messages, $isUnique = false)
    {
		if ($isUnique) {
			// ユニークチェック用のデータを入れる
			$origin = factory(User::class)->create([
				'location_id' => 1,
				'name' => 'test',
				'email' => 'test2@test.com',
				'password' => Hash::make('test'),
			]);
		}

		$response = $this->post('/users', $dataList);
		$response
			->assertStatus($status)
			->assertJson($messages);

		if ($isUnique) {
			$response = $this->put('/users/' . $origin->id, $dataList);
			$response->assertStatus(200);
		}
    }

    public function userDataProvider()
    {
        $this->refreshApplication();
        return [
            '成功' => [
                [
                    'location_id' => 1,
                    'name' => 'test',
                    'email' => 'test@test.com',
                    'password' => Hash::make('test'),
                ],
                200,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'name' => '',
                    'email' => '',
                    'password' => '',
                ],
                422,
                [
                    'location_id' => ['拠点を入力してください。'],
                    'name' => ['名称を入力してください。'],
                    'email' => ['メールアドレスを入力してください。'],
                    'password' => ['パスワードを入力してください。'],
                ],
            ],
            '失敗(unique)' => [
                [
                    'location_id' => 1,
                    'name' => 'test',
                    'email' => 'test2@test.com',
                    'password' => Hash::make('test'),
                ],
                422,
                [
                    'email' => ['このメールアドレスは既に存在します。'],
                ],
                true,
            ],
            '失敗(email)' => [
                [
                    'location_id' => 1,
                    'name' => 'test',
                    'email' => 'test2',
                    'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                ],
                422,
                [
                    'email' => ['メールアドレスを正しい形式で入力してください。'],
                ],
            ],
        ];
    }
}
