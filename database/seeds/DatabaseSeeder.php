<?php

use App\Brand;
use App\Company;
use App\Location;
use App\LocationType;
use App\Lot;
use App\Palette;
use App\Product;
use App\StockHistory;
use App\StockHistoryType;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * @var \Faker\Factory
     */
    protected $faker;

    /**
     * DatabaseSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Create a company.
     *
     * @return \App\Company
     */
    protected function createCompany(): Company
    {
        return factory(Company::class)->create();
    }

    /**
     * Create brands.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Support\Collection|\App\Brand[]
     */
    protected function createBrands(Company $company): Collection
    {
        return collect(factory(Brand::class, 4)->create([
            'company_id' => $company->id,
        ]));
    }

    /**
     * Create products.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Support\Collection|\App\Product[]
     */
    protected function createProducts(Brand $brand): Collection
    {
        return collect(factory(Product::class, rand(5, 12))->create([
            'brand_id' => $brand->id,
        ]));
    }


    /**
     * Create lots of the specified product.
     *
     * @param  \App\Product  $product
     * @param  string  $productName
     * @return \Illuminate\Support\Collection|\App\Product[]
     */
    protected function createLots(Product $product, string $productName): array
    {
        $lots = [];
        $ordered_at = $this->faker->dateTimeBetween(new Carbon('-2 years'), new Carbon('-4 months'));

        for ($i=0; $i<=rand(1, 5); $i++) {
            $lots[] = [
                'product_id' => $product->id,
                'lot_number' => uniqid(),
                'name' => $productName . ' ' . $this->faker->word,
                'ordered_at' => $ordered_at,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Lot::query()->insert($lots);

        return $lots;
    }

    /**
     * Create recipes for any lots.
     *
     * @param  \App\Brand  $brand
     */
    protected function createRecipe(Brand $brand) {
        $parentProducts = $brand->products()->get();
        $childProducts = $parentProducts->splice(2);

        $parentProducts->each(function (Product $product) use ($childProducts) {
            $number = rand(2, $childProducts->count());
            $materials = $childProducts->random($number);

            $product->lots()->each(function (Lot $parentLot) use ($materials) {
                $materialLots = $materials
                    ->map(function (Product $product) {
                        return $product->lots()->get()->random();
                    });

                $materialLots->each(function (Lot $childLot) use ($parentLot) {
                    DB::table('materials')->insert(
                        [
                            'parent_lot_id' => $parentLot->id,
                            'child_lot_id' => $childLot->id,
                            'amount' => rand(3, 100),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                });
            });
        });
    }

    /**
     * Create location types with given values.
     *
     * @param  array  $values
     * @param  \App\Company  $company
     * @return \Illuminate\Support\Collection|\App\LocationType[]
     */
    protected function createLocationTypes(array $values, Company $company): Collection
    {
        return collect($values)->map(function ($value) use ($company) {
            return factory(LocationType::class)->create([
                'company_id' => $company->id,
                'name' => $value,
            ]);
        });
    }

    /**
     * Create stock history types with given values.
     *
     * @param  array  $values
     * @param  \App\Company  $company
     * @return void
     */
    protected function createStockHistoryTypes(array $values, Company $company)
    {
        collect($values)->reduce(function ($sub, $value) use ($company) {
            $sub[$value] = factory(StockHistoryType::class)->create([
                'company_id' => $company->id,
                'name' => $value,
            ]);
        }, []);
    }

    /**
     * Create locations of given location type.
     *
     * @param  \App\LocationType  $locationType
     * @param  \App\Company  $company
     * @return \Illuminate\Support\Collection|\App\Location[]
     */
    protected function createLocations(LocationType $locationType, Company $company): Collection {
        return collect(factory(Location::class, rand(2, 5))->create([
            'company_id' => $company->id,
            'location_type_id' => $locationType->id,
        ]));
    }

    /**
     * Create users of the specified location.
     *
     * @param  \App\Location  $location
     */
    protected function createUsers(Location $location)
    {
        factory(User::class, rand(3, 5))->create([
            'location_id' => $location->id,
        ]);
    }

    /**
     * Create palettes of the specified location.
     *
     * @param  \App\Location  $location
     */
    protected function createPalettes(Location $location)
    {
        factory(Palette::class)->create([
            'location_id' => $location->id,
        ]);
    }

    /**
     * Create stock histories for the specified location.
     *
     * @param  \App\Location  $location
     */
    protected function createStockHistory(Location $location)
    {
        $lots = Lot::all();
        $stockHistoryTypes = StockHistoryType::all();

        factory(StockHistory::class)->create([
            'location_id' => $location->id,
            'lot_id' => $lots->random()->id,
            'stock_history_type_id' => $stockHistoryTypes->random()->id,
        ]);
    }

    /**
     * Create palette stocks in the specified location.
     *
     * @param  \App\Location  $location
     */
    protected function createLocationPalette(Location $location)
    {
        $palettes = Palette::all();
        $number = rand(0, $palettes->count());
        if ($number == 0) return;

        $palettes->random($number)->each(function (Palette $palette) use ($location) {
            DB::table('location_palette')->insert(
                [
                    'location_id' => $location->id,
                    'palette_id' => $palette->id,
                    'quantity' => rand(1, 100) * 10,
                ]
            );
        });
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company = $this->createCompany();

        $this->createStockHistoryTypes(['出荷', '入荷', '棚卸し'], $company);

        $this->createBrands($company)->each(function (Brand $brand) {
            $this->createProducts($brand)
                ->each(function (Product $product) {
                    $productName = $this->faker->streetName;
                    $this->createLots($product, $productName);
                });

            $this->createRecipe($brand);
        });

        $this->createLocationTypes(['拠点', '倉庫', '製造所'], $company)
            ->each(function (LocationType $locationType) use ($company) {
                $this->createLocations($locationType, $company)
                    ->each(function (Location $location) {
                        $this->createUsers($location);
                        $this->createPalettes($location);
                        $this->createStockHistory($location);
                        $this->createLocationPalette($location);
                    });
            });
    }
}
