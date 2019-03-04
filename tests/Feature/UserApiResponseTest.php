<?php

namespace Tests\Feature;

use App\Location;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiResponseTest extends TestCase
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
     * ユーザーのリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $users = User::all();

        $this->get('/users')
            ->assertSuccessful()
            ->assertJsonCount($users->count())
            ->assertJson($users->toArray());
    }

    /**
     * ユーザーの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $user = User::query()->first();

        $this->get('/users/' . $user->id)
            ->assertSuccessful()
            ->assertJson($user->toArray());
    }

    /**
     * ユーザーを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'location_id' => Location::query()->first()->id,
            'name' => 'testUser',
            'email' => 'testUser@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ];
        $response = $this->post('/users', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * ユーザーを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create([
            'location_id' => Location::query()->first()->id
        ]);

        $data = [
            'location_id' => Location::query()->first()->id,
            'name' => 'testUpdateUser',
            'email' => 'testUpdateUser@gmail.com',
        ];

        $this->put('/users/'. $user->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = User::query()->find($user->id)->toArray();

        unset($data['location_id']);
        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * ユーザーを削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = factory(User::class)->create([
            'location_id' => Location::query()->first()->id
        ]);
        $count = User::query()->count();

        $this->delete('/users/'. $user->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, User::query()->get());
    }
}
