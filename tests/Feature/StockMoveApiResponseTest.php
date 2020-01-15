<?php

namespace Tests\Feature;

use App\Location;
use App\Lot;
use App\StockHistory;
use App\StockHistoryType;
use App\StockMove;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockMoveApiResponseTest extends TestCase
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
        $stockMoves = StockMove::all();

        $this->get('/stock_moves')
            ->assertSuccessful()
            ->assertJsonCount($stockMoves->count())
            ->assertJson($stockMoves->toArray());
    }

    /**
     * ユーザーの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $stockMove = StockMove::query()->first();

        $this->get('/stock_moves/' . $stockMove->id)
            ->assertSuccessful()
            ->assertJson($stockMove->toArray());
    }

    /**
     * ユーザーを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'shipping_id' => StockHistory::query()->first()->id,
            'receiving_id' => StockHistory::query()->first()->id,
            'location_id' => Location::query()->first()->id,
            'quantity' => 100,
        ];
        $response = $this->post('/stock_moves', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * ユーザーを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $stockMove = factory(StockMove::class)->create([
            'shipping_id' => StockHistory::query()->first()->id,
            'receiving_id' => StockHistory::query()->first()->id,
            'location_id' => Location::query()->first()->id,
        ]);

        $data = [
            'shipping_id' => StockHistory::query()->first()->id,
            'receiving_id' => StockHistory::query()->first()->id,
            'location_id' => Location::query()->first()->id,
            'quantity' => 100,
        ];

        $this->put('/stock_moves/'. $stockMove->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = StockMove::query()->find($stockMove->id)->toArray();

        unset($data['shipping_id']);
        unset($data['receiving_id']);
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
        $stockMove = factory(StockMove::class)->create([
            'shipping_id' => StockHistory::query()->first()->id,
            'receiving_id' => StockHistory::query()->first()->id,
            'location_id' => Location::query()->first()->id,
        ]);
        $count = StockMove::query()->count();

        $this->delete('/stock_moves/'. $stockMove->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, StockMove::query()->get());
    }
}
