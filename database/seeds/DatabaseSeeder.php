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

        foreach ($location_types as $location_type) {
            $locations[] = factory(\App\Location::class, 10)->create([
                'location_type_id' => $location_type->id,
                'company_id' => $company->id,
            ]);
        }

        $company->main_location_id = $locations->first()[0]->id;
        $company->save();
    }
}
