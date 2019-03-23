<?php

namespace Tests\Feature;

use App\Brand;
use App\Company;
use App\Http\Requests\MaterialRequest;
use App\LocationType;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialApiValidationTest extends TestCase
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
     * バリデーションテスト
     *
     * @param array $dataList
     * @param boolean $expect
     * @param array $messages
     * @param boolean $isUnique
     * @dataProvider brandDataProvider
     */
    public function testValidation($dataList, $expect, $messages, $isUnique=false)
    {
        if ($expect) {
            $dataList =  [
                'parent_lot_id' => factory(\App\Lot::class)->create([
                    'location_id' => factory(\App\Location::class)->create([
                        'location_type_id' => 1,
                        'company_id' => Company::query()->first()->id,
                    ])->id,
                    'brand_id' => Brand::query()->first()->id
                ])->id,
                'child_lot_id' => factory(\App\Lot::class)->create([
                    'location_id' => factory(\App\Location::class)->create([
                        'location_type_id' => 2,
                        'company_id' => Company::query()->first()->id,
                    ])->id,
                    'brand_id' => Brand::query()->first()->id
                ])->id,
            ];
        }
        if ($isUnique) {
            // ユニークチェック用のデータを入れる
            $lots = factory(\App\Lot::class, 2)->create([
                'location_id' => factory(\App\Location::class)->create([
                    'location_type_id' => LocationType::query()->first()->id,
                    'company_id' => Company::query()->first()->id,
                ])->id,
                'brand_id' => factory(Brand::class)->create()->id,
            ]);
            $data = ['parent_lot_id' => $lots[0]->id, 'child_lot_id' => $lots[1]->id];
            $this->post('/materials', $data);
        }
        $request = new MaterialRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        // バリデーション結果が正しいか確認
        $this->assertEquals($expect, $result);
        $result_messages = $validator->errors()->toArray();
        // エラーメッセージが正しいか確認
        foreach ($messages as $key => $value) {
            $this->assertEquals($value, $result_messages[$key]);
        }
    }

    public function brandDataProvider()
    {
        return [
            '成功' => [
                [
                    'parent_lot_id' => '',
                    'child_lot_id' => '',
                ],
                true,
                [],
            ],
            '失敗(required)' => [
                [
                    'parent_lot_id' => '',
                    'child_lot_id' => '',
                ],
                false,
                [
                    'parent_lot_id' => ['親ロットを入力してください。'],
                    'child_lot_id' => ['子ロットを入力してください。'],
                ],
            ],
//            '失敗(unique)' => [
//                [
//                    'parent_lot_id' => $material->parent_lot_id,
//                    'child_lot_id' => $material->child_lot_id,
//                ],
//                false,
//                [
//                    'parent_lot_id' => ['この親ロットは既に存在します。'],
//                    'child_lot_id' => ['この子ロットは既に存在します。'],
//                ],
//                true,
//            ],
        ];
    }
}
