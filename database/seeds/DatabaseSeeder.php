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
        /** @var \App\Brand $brand */
        $brand = factory(\App\Brand::class)->create();

        $locations = collect();
        $palettes = collect();

        foreach ($location_types as $index => $location_type) {
            /** @var \App\LocationType $location_type */
            $locations[] = factory(\App\Location::class, 10)->create([
                'location_type_id' => $location_type->id,
                'company_id' => $company->id,
            ]);
            foreach ($locations[$index] as $location) {
                factory(\App\User::class, 1)->create([
                    'location_id' => $location->id
                ]);
                $palettes[] = factory(\App\Palette::class, 1)->create([
                    'location_id' => $location->id
                ]);

                /** @var \App\Lot[] $lots */
                $lots[] = factory(\App\Lot::class, 3)->create([
                    'location_id' => $location->id,
                    'brand_id' => $brand->id,
                ]);
                DB::table('materials')->insert(
                    [
                        'parent_lot_id' => $lots[$j]->random()->id,
                        'child_lot_id' => $lots[$j]->random()->id,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]
                );
            }
            DB::table('location_palette')->insert(
                [
                    'location_id' => $locations[0]->random()->id,
                    'palette_id' => $palettes[0]->random()->id,
                    'quantity' => 100,
                ]
            );
        }
    }
}
