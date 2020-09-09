<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Brand\BrandRepositoryInterface::class,
            \App\Repositories\Brand\BrandRepository::class
        );
        $this->app->bind(
            \App\Repositories\Company\CompanyRepositoryInterface::class,
            \App\Repositories\Company\CompanyRepository::class
        );
        $this->app->bind(
            \App\Repositories\Location\LocationRepositoryInterface::class,
            \App\Repositories\Location\LocationRepository::class
        );
        $this->app->bind(
            \App\Repositories\Palette\PaletteRepositoryInterface::class,
            \App\Repositories\Palette\PaletteRepository::class
        );
        $this->app->bind(
            \App\Repositories\LocationType\LocationTypeRepositoryInterface::class,
            \App\Repositories\LocationType\LocationTypeRepository::class
        );
        $this->app->bind(
            \App\Repositories\Lot\LotRepositoryInterface::class,
            \App\Repositories\Lot\LotRepository::class
        );
        $this->app->bind(
            \App\Repositories\Material\MaterialRepositoryInterface::class,
            \App\Repositories\Material\MaterialRepository::class
        );
        $this->app->bind(
            \App\Repositories\Product\ProductRepositoryInterface::class,
            \App\Repositories\Product\ProductRepository::class
        );
        $this->app->bind(
            \App\Repositories\StockMove\StockMoveRepositoryInterface::class,
            \App\Repositories\StockMove\StockMoveRepository::class
        );
        $this->app->bind(
            \App\Repositories\StockHistory\StockHistoryRepositoryInterface::class,
            \App\Repositories\StockHistory\StockHistoryRepository::class
        );
        $this->app->bind(
            \App\Repositories\StockHistoryType\StockHistoryTypeRepositoryInterface::class,
            \App\Repositories\StockHistoryType\StockHistoryTypeRepository::class
        );
        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\UserInvite\UserInviteRepositoryInterface::class,
            \App\Repositories\UserInvite\UserInviteRepository::class
        );
        $this->app->bind(
            \App\Repositories\UserVerification\UserVerificationRepositoryInterface::class,
            \App\Repositories\UserVerification\UserVerificationRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
