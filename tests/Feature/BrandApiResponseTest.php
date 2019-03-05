<?php

namespace Tests\Feature;

use App\Brand;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandApiResponseTest extends TestCase
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
     * ブランドのリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $brands = Brand::all()->makeHidden(['lots']);

        $this->get('/brands')
            ->assertSuccessful()
            ->assertJsonCount($brands->count())
            ->assertJson($brands->toArray());
    }

    /**
     * ブランドの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $brand = Brand::query()->first();

        $this->get('/brands/' . $brand->id)
            ->assertSuccessful()
            ->assertJson($brand->toArray());
    }

    /**
     * ブランドを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'name' => 'testBrand',
            'code' => 'testCode',
        ];
        $response = $this->post('/brands', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * ブランドを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $brand = factory(Brand::class)->create();

        $data = [
            'name' => 'testUpdateBrand',
            'code' => 'testUpdateCode',
        ];

        $this->put('/brands/'. $brand->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Brand::query()->find($brand->id)->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * ブランドを削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $brand = factory(Brand::class)->create();
        $count = Brand::query()->count();

        $this->delete('/brands/'. $brand->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Brand::query()->get());
    }
}
