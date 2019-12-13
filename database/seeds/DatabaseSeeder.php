<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Company $company */
        $company = factory(\App\Company::class)->create();
        /** @var \App\LocationType[] $location_types */
        $location_types = factory(\App\LocationType::class, 3)->create([
            'company_id' => $company->id
        ]);
        /** @var \App\StockHistoryType[] $stock_history_types */
        $stock_history_types = [];
        $stock_history_type_values = ['出荷', '入荷', '棚卸し'];
        foreach ($stock_history_type_values as $stock_history_type_value) {
            $stock_history_types[] = \App\StockHistoryType::create([
                'name' => $stock_history_type_value,
                'company_id' => $company->id
            ]);
        }
        /** @var \App\Brand $brand */
        $brand = factory(\App\Brand::class)->create([
            'company_id' => $company->id
        ]);
        /** @var \App\Product $product */
        $product = factory(\App\Product::class)->create([
            'brand_id' => $brand->id
        ]);

        $locations = collect();
        $palettes = collect();
        $lots = collect();
        $stock_histories = collect();

        foreach ($location_types as $index => $location_type) {
            /** @var \App\Location[] $locations */
            $locations[] = factory(\App\Location::class, 10)->create([
                'location_type_id' => $location_type->id,
                'company_id' => $company->id,
            ]);
            foreach ($locations[$index] as $j => $location) {
                factory(\App\User::class, 1)->create([
                    'location_id' => $location->id
                ]);
                /** @var \App\Palette[] $palettes */
                $palettes[] = factory(\App\Palette::class, 1)->create([
                    'location_id' => $location->id
                ]);

                /** @var \App\Lot[] $lots */
                $lots[] = factory(\App\Lot::class, 3)->create([
                    'product_id' => $product->id,
                ]);
                DB::table('materials')->insert(
                    [
                        'parent_lot_id' => $lots[$j]->random()->id,
                        'child_lot_id' => $lots[$j]->random()->id,
                        'amount' => 100,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]
                );
                /** @var \App\StockHistory $stock_histories */
                $stock_histories[] = factory(\App\StockHistory::class)->create([
                    'location_id' => $location->id,
                    'lot_id' => $lots[$j]->random()->id,
                    'stock_history_type_id' => $stock_history_types->random()->id
                ]);
            }
            DB::table('location_palette')->insert(
                [
                    'location_id' => $locations[0]->random()->id,
                    'palette_id' => $palettes[0]->random()->id,
                    'quantity' => 100,
                ]
            );
        }
        factory(\App\StockMove::class)->create([
            'recieving_location_id' => $locations[0]->random()->id,
            'shipping_location_id' => $locations[1]->random()->id,
            'lot_id' => $lots[0]->random()->id,
        ]);
        factory(\App\StockMove::class)->create([
            'shipping_id' => $stock_histories[1]->id,
            'recieving_id' => $stock_histories[0]->id,
            'location_id' => $stock_histories[0]->location_id,
        ]);
    }
}
