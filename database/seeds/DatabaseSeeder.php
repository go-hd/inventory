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
        /** @var \App\LocationType[] $location_types */
        $location_types = factory(\App\LocationType::class, 3)->create();
        /** @var \App\Company $company */
        $company = factory(\App\Company::class)->create();

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
