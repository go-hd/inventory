<?php

namespace Tests\Feature;

use App\Brand;
use App\Location;
use App\Lot;
use App\Product;
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
        $lots = Lot::query()->orderBy('created_at', 'desc')->get()->makeHidden(['stock_histories', 'product']);

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
        $lot = Lot::query()->first();

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
            'product_id' => Product::query()->get()->random()->id,
            'lot_number' => 'a0a0a0a0a0a0',
            'name' => 'testName',
            'ordered_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'ordered_quantity' => 100,
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
            'product_id' => Product::query()->get()->random()->id,
        ]);

        $data = [
            'product_id' => Product::query()->get()->random()->id,
            'lot_number' => 'b0b0b0b0b0b0',
            'name' => 'testUpdateName',
            'ordered_at' => Carbon::now()->format('Y-m-d'),
            'ordered_quantity' => 100,
        ];

        $this->put('/lots/'. $lot->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Lot::query()->find($lot->id)->toArray();

        unset ($data['product_id']);
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
            'product_id' => Product::query()->get()->random()->id,
        ]);
        $count = Lot::query()->count();

        $this->delete('/lots/'. $lot->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Lot::query()->get());
    }
}