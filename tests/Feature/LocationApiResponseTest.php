<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Location;
use App\Models\LocationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationApiResponseTest extends TestCase
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
        $this->artisan('db:seed');
    }

    /**
     * 拠点のリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $locations = Location::all();

        $this->get('/locations')
            ->assertSuccessful()
            ->assertJsonCount($locations->count())
            ->assertJson($locations->toArray());
    }

    /**
     * 拠点の詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $Location = Location::query()->first();

        $this->get('/locations/' . $Location->id)
            ->assertSuccessful()
            ->assertJson($Location->toArray());
    }

    /**
     * 拠点を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'company_id' => Company::query()->first()->id,
            'name' => 'testLocation',
            'location_type_id' => LocationType::query()->first()->id,
            'location_code' => 'AA',
            'location_number' => '1234',
        ];
        $response = $this->post('/locations', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * 拠点を更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $Location = factory(Location::class)->create();

        $data = [
            'name' => 'testUpdateLocation',
            'location_type_id' => LocationType::query()->get()->random()->id,
            'location_code' => 'BB',
            'location_number' => '5678',
        ];

        $this->put('/locations/'. $Location->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Location::query()->find($Location->id)->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * 拠点を削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $Location = factory(Location::class)->create();
        $count = Location::query()->count();

        $this->delete('/locations/'. $Location->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Location::query()->get());
    }
}
