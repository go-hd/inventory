<?php

namespace Tests\Feature;

use App\Location;
use App\Palette;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaletteApiResponseTest extends TestCase
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
     * パレットのリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $palettes = Palette::all()->makeHidden(['shared_locations']);

        $this->get('/palettes')
            ->assertSuccessful()
            ->assertJsonCount($palettes->count())
            ->assertJson($palettes->toArray());
    }

    /**
     * パレットの詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $palette = Palette::query()->first();

        $this->get('/palettes/' . $palette->id)
            ->assertSuccessful()
            ->assertJson($palette->toArray());
    }

    /**
     * パレットを新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'palette' => [
                'location_id' => Location::query()->first()->id,
                'type' => 'TestPalette',
            ]
        ];
        $response = $this->post('/palettes', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * パレットを更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $palette = factory(Palette::class)->create([
            'location_id' => Location::query()->first()->id
        ]);

        $data = [
            'palette' => [
                'location_id' => Location::query()->first()->id,
                'type' => 'UpdatedTestPalette',
            ]
        ];

        $this->put('/palettes/'. $palette->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Palette::query()->find($palette->id)->toArray();

        unset($data['palette']['location_id']);
        foreach ($data['palette'] as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * パレットを削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $palette = factory(Palette::class)->create([
            'location_id' => Location::query()->first()->id
        ]);
        $count = Palette::query()->count();

        $this->delete('/palettes/'. $palette->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Palette::query()->get());
    }
}
