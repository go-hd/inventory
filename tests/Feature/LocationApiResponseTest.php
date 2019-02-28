<?php

namespace Tests\Feature;

use App\Company;
use App\Location;
use App\LocationType;
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
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    /**
     * 拠点のリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $locations = Location::all()->makeHidden(['users', 'lots', 'own_palettes', 'palettes']);

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
        $location = Location::query()->first();

        $this->get('/locations/' . $location->id)
            ->assertSuccessful()
            ->assertJson($location->toArray());
    }

    /**
     * 拠点を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'location' => [
                'company_id' => Company::query()->first()->id,
                'name' => 'testLocation',
                'location_type_id' => LocationType::query()->first()->id,
                'location_code' => 'AA',
                'location_number' => '1234',
            ]
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
        $location = factory(Location::class)->create([
            'location_type_id' => LocationType::query()->first()->id,
            'company_id' => Company::query()->first()->id,
        ]);

        $data = [
            'location' => [
                'company_id' => Company::query()->first()->id,
                'name' => 'testUpdateLocation',
                'location_type_id' => LocationType::query()->get()->random()->id,
                'location_code' => 'BB',
                'location_number' => '5678',
            ]
        ];

        $this->put('/locations/'. $location->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Location::query()->find($location->id)->toArray();

        unset($data['location']['company_id']);
        unset($data['location']['location_type_id']);
        foreach ($data['location'] as $key => $value) {
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
        $location = factory(Location::class)->create([
            'location_type_id' => LocationType::query()->first()->id,
            'company_id' => Company::query()->first()->id,
        ]);
        $count = Location::query()->count();

        $this->delete('/locations/'. $location->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Location::query()->get());
    }
}
