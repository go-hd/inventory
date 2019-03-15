<?php

namespace Tests\Feature;

use App\Lot;
use App\Recipe;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeApiResponseTest extends TestCase
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
        $recipes = Recipe::all();

        $this->get('/recipes')
            ->assertSuccessful()
            ->assertJsonCount($recipes->count())
            ->assertJson($recipes->toArray());
    }

    /**
     * レシピの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $lot = Recipe::query()->first();

        $this->get('/recipes/' . $lot->id)
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
        ];
        $response = $this->post('/recipes', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * レシピを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $lot = factory(Recipe::class)->create([
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
        ]);

        $data = [
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
        ];

        $this->put('/recipes/'. $lot->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Recipe::query()->find($lot->id)->toArray();

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
        $lot = factory(Recipe::class)->create([
            'parent_lot_id' => Lot::query()->get()->random()->id,
            'child_lot_id' => Lot::query()->get()->random()->id,
        ]);
        $count = Recipe::query()->count();

        $this->delete('/recipes/'. $lot->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Recipe::query()->get());
    }
}
