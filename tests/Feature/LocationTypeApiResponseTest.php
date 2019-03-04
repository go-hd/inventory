<?php

namespace Tests\Feature;

use App\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTypeTypeApiResponseTest extends TestCase
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
     * 拠点種別のリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $locationTypeTypes = LocationType::all();

        $this->get('/location_types')
            ->assertSuccessful()
            ->assertJsonCount($locationTypeTypes->count())
            ->assertJson($locationTypeTypes->toArray());
    }

    /**
     * 拠点種別の詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $locationType = LocationType::query()->first()->setAppends(['locations']);

        $this->get('/location_types/' . $locationType->id)
            ->assertSuccessful()
            ->assertJson($locationType->toArray());
    }

    /**
     * 拠点種別を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = ['name' => 'TestLocationType'];
        $response = $this->post('/location_types', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * 拠点種別を更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $locationType = factory(LocationType::class)->create();

        $data = ['name' => 'UpdatedTestLocationType'];

        $this->put('/location_types/'. $locationType->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = LocationType::query()->find($locationType->id)->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * 拠点種別を削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $locationType = factory(LocationType::class)->create();
        $count = LocationType::query()->count();

        $this->delete('/location_types/'. $locationType->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, LocationType::query()->get());
    }
}
