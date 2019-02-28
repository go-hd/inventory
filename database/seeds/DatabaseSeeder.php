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

        foreach ($location_types as $index => $location_type) {
            /** @var \App\Models\LocationType $location_type */
            $locations[] = factory(\App\Location::class, 10)->create([
                'location_type_id' => $location_type->id,
                'company_id' => $company->id,
            ]);
            factory(\App\Models\User::class, 1)->create([
                'location_id' => $locations->get($index)[0]->id
            ]);
        }
    }
}
