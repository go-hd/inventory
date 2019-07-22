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

class ProductApiResponseTest extends TestCase
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
     * 商品のリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $products = Product::all();

        $this->get('/products')
            ->assertSuccessful()
            ->assertJsonCount($products->count())
            ->assertJson($products->toArray());
    }

    /**
     * 商品の詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $product = Product::query()->first();

        $this->get('/products/' . $product->id)
            ->assertSuccessful()
            ->assertJson($product->toArray());
    }

    /**
     * 商品を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'brand_id' => Brand::query()->get()->random()->id,
            'jan_code' => '0000000000000',
        ];
        $response = $this->post('/products', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * 商品を更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $product = factory(Product::class)->create([
            'brand_id' => Brand::query()->get()->random()->id,
        ]);

        $data = [
            'brand_id' => Brand::query()->get()->random()->id,
            'jan_code' => '1111111111111',
        ];

        $this->put('/products/'. $product->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Product::query()->find($product->id)->toArray();

        unset($data['location_id']);
        unset($data['brand_id']);
        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * 商品を削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $product = factory(Product::class)->create([
            'brand_id' => Brand::query()->get()->random()->id,
        ]);
        $count = Product::query()->count();

        $this->delete('/products/'. $product->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Product::query()->get());
    }
}
