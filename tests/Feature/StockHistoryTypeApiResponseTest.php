<?php

namespace Tests\Feature;

use App\Company;
use App\StockHistoryType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockHistoryTypeApiResponseTest extends TestCase
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
        $stockHistoryTypes = StockHistoryType::all()->makeHidden(['stock_histories']);

        $this->get('/stock_history_types')
            ->assertSuccessful()
            ->assertJsonCount($stockHistoryTypes->count())
            ->assertJson($stockHistoryTypes->toArray());
    }

    /**
     * 拠点種別の詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $stockHistoryType = StockHistoryType::query()->first();

        $this->get('/stock_history_types/' . $stockHistoryType->id)
            ->assertSuccessful()
            ->assertJson($stockHistoryType->toArray());
    }

    /**
     * 拠点種別を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'company_id' => Company::query()->first()->id,
            'name' => 'TestStockHistoryType',
        ];
        $response = $this->post('/stock_history_types', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * 拠点種別を更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $stockHistoryType = factory(StockHistoryType::class)->create([
            'company_id' => Company::query()->first()->id,
        ]);

        $data = [
            'company_id' => Company::query()->first()->id,
            'name' => 'UpdatedTestStockHistoryType',
        ];

        $this->put('/stock_history_types/'. $stockHistoryType->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = StockHistoryType::query()->find($stockHistoryType->id)->toArray();

        unset($data['company_id']);
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
        $stockHistoryType = factory(StockHistoryType::class)->create([
            'company_id' => Company::query()->first()->id,
        ]);
        $count = StockHistoryType::query()->count();

        $this->delete('/stock_history_types/'. $stockHistoryType->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, StockHistoryType::query()->get());
    }
}
