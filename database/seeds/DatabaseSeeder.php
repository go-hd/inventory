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
        $location_types = factory(\App\Models\LocationType::class, 3)->create();
        /** @var \App\Models\Company $company */
        $company = factory(\App\Models\Company::class)->create();

        $locations = collect();

        foreach ($location_types as $location_type) {
            /** @var \App\Models\LocationType $location_type */
            $locations[] = factory(\App\Models\Location::class, 10)->create([
                'location_type_id' => $location_type->id,
                'company_id' => $company->id,
            ]);
        }

        $company->main_location_id = $locations->first()[0]->id;
        $company->save();
    }
}
