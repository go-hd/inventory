<?php

namespace Tests\Feature;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
     * @param array $dataList
     * @param boolean $expect
     * @param array $messages
     * @param boolean $isUnique
     * @dataProvider brandDataProvider
     */
    public function testValidation($dataList, $expect, $messages, $isUnique=false)
    {
        if ($isUnique) {
            // ユニークチェック用のデータを入れる
            $data = ['location_id' => 1, 'name' => 'test', 'email' => 'test2@test.com', 'password' => Hash::make('test')];
            $this->post('/users', $data);
        }
        $request = new UserRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        // バリデーション結果が正しいか確認
        $this->assertEquals($expect, $result);
        $result_messages = $validator->errors()->toArray();
        // エラーメッセージが正しいか確認
        foreach ($messages as $key => $value) {
            $this->assertEquals($value, $result_messages[$key]);
        }
    }

    public function brandDataProvider()
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
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'location_id' => '',
                    'name' => '',
                    'email' => '',
                    'password' => '',
                ],
                false,
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
                false,
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
                false,
                [
                    'email' => ['メールアドレスを正しい形式で入力してください。'],
                ],
            ],
        ];
    }
}
