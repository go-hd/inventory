<?php

namespace Tests\Feature;

use App\Lot;
use App\Material;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialApiResponseTest extends TestCase
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
     * レシピのリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $materials = Material::all();

        $this->get('/materials')
            ->assertSuccessful()
            ->assertJsonCount($materials->count())
            ->assertJson($materials->toArray());
    }

    /**
     * レシピの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $lot = Material::query()->first();

        $this->get('/materials/' . $lot->id)
            ->assertSuccessful()
            ->assertJson($lot->toArray());
    }

    /**
     * レシピを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
            'amount' => 100,
        ];
        $response = $this->post('/materials', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * レシピを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $lot = factory(Material::class)->create([
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
            'amount' => 100,
        ]);

        $data = [
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
            'amount' => 200,
        ];

        $this->put('/materials/'. $lot->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Material::query()->find($lot->id)->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * レシピを削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $lot = factory(Material::class)->create([
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
            'amount' => 100,
        ]);
        $count = Material::query()->count();

        $this->delete('/materials/'. $lot->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Material::query()->get());
    }
}
