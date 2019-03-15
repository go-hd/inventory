<?php

namespace Tests\Feature;

use App\Location;
use App\Lot;
use App\StockHistory;
use App\StockHistoryType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockHistoryApiResponseTest extends TestCase
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
        $stockHistories = StockHistory::all();

        $this->get('/stock_histories')
            ->assertSuccessful()
            ->assertJsonCount($stockHistories->count())
            ->assertJson($stockHistories->toArray());
    }

    /**
     * ユーザーの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $stockHistory = StockHistory::query()->first();

        $this->get('/stock_histories/' . $stockHistory->id)
            ->assertSuccessful()
            ->assertJson($stockHistory->toArray());
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
            'lot_id' => Lot::query()->first()->id,
            'stock_history_type_id' => StockHistoryType::query()->first()->id,
            'quantity' => 100,
        ];
        $response = $this->post('/stock_histories', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * ユーザーを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $stockHistory = factory(StockHistory::class)->create([
            'location_id' => Location::query()->first()->id,
            'lot_id' => Lot::query()->first()->id,
            'stock_history_type_id' => StockHistoryType::query()->first()->id,
        ]);

        $data = [
            'location_id' => Location::query()->first()->id,
            'lot_id' => Lot::query()->first()->id,
            'stock_history_type_id' => StockHistoryType::query()->first()->id,
            'quantity' => 100,
        ];

        $this->put('/stock_histories/'. $stockHistory->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = StockHistory::query()->find($stockHistory->id)->toArray();

        unset($data['location_id']);
        unset($data['lot_id']);
        unset($data['stock_history_type_id']);
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
        $stockHistory = factory(StockHistory::class)->create([
            'location_id' => Location::query()->first()->id,
            'lot_id' => Lot::query()->first()->id,
            'stock_history_type_id' => StockHistoryType::query()->first()->id,
        ]);
        $count = StockHistory::query()->count();

        $this->delete('/stock_histories/'. $stockHistory->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, StockHistory::query()->get());
    }
}
