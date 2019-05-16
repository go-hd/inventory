<?php

namespace Tests\Feature;

use App\Brand;
use App\Location;
use App\Lot;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotApiResponseTest extends TestCase
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
     * ロットのリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $lots = Lot::all()->makeHidden(['brand', 'location', 'stock_histories']);

        $this->get('/lots')
            ->assertSuccessful()
            ->assertJsonCount($lots->count())
            ->assertJson($lots->toArray());
    }

    /**
     * ロットの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $lot = Lot::query()->first()->makeHidden(['brand_name', 'location_name']);

        $this->get('/lots/' . $lot->id)
            ->assertSuccessful()
            ->assertJson($lot->toArray());
    }

    /**
     * ロットを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'location_id' => Location::query()->get()->random()->id,
            'brand_id' => Brand::query()->get()->random()->id,
            'lot_number' => 'a0a0a0a0a0a0',
            'name' => 'testName',
            'jan_code' => '0000000000000',
            'ordered_at' => Carbon::now()->format('Y-m-d'),
        ];
        $response = $this->post('/lots', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * ロットを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $lot = factory(Lot::class)->create([
            'location_id' => Location::query()->get()->random()->id,
            'brand_id' => Brand::query()->get()->random()->id,
        ]);

        $data = [
            'location_id' => Location::query()->get()->random()->id,
            'brand_id' => Brand::query()->get()->random()->id,
            'lot_number' => 'b0b0b0b0b0b0',
            'name' => 'testUpdateName',
            'jan_code' => '1111111111111',
            'ordered_at' => Carbon::now()->format('Y-m-d'),
        ];

        $this->put('/lots/'. $lot->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Lot::query()->find($lot->id)->toArray();

        unset($data['location_id']);
        unset($data['brand_id']);
        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * ロットを削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $lot = factory(Lot::class)->create([
            'location_id' => Location::query()->get()->random()->id,
            'brand_id' => Brand::query()->get()->random()->id,
        ]);
        $count = Lot::query()->count();

        $this->delete('/lots/'. $lot->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Lot::query()->get());
    }
}
