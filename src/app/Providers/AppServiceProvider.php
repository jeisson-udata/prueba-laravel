<?php

namespace App\Providers;

use App\Repositories\ReservationLogRepository;
use App\Repositories\ReservationLogRepositoryInterface;
use App\Repositories\ReservationRepository;
use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\ResourceRepository;
use App\Repositories\ResourceRepositoryInterface;
use App\Repositories\ResourceTypeRepository;
use App\Repositories\ResourceTypeRepositoryInterface;
use App\Services\ReservationService;
use App\Services\ResourceService;
use App\Services\ResourceTypeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        /**
         * Repositories
         */
        $this->app->bind(ReservationLogRepositoryInterface::class, ReservationLogRepository::class);
        $this->app->bind(ResourceTypeRepositoryInterface::class, ResourceTypeRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(ResourceRepositoryInterface::class, ResourceRepository::class);


        /**
         * ResourceType Service
         */
        $this->app->bind(ResourceTypeService::class, function ($app) {
            return new ResourceTypeService($app->make(ResourceTypeRepositoryInterface::class));
        });

        /**
         * Reservation Service
         */
        $this->app->bind(ReservationService::class, function ($app) {
            return new ReservationService($app->make(ReservationRepositoryInterface::class), $app->make(ReservationLogRepositoryInterface::class), $app->make(ResourceRepositoryInterface::class));
        });


        /**
         * Resource Service
         */
        $this->app->bind(ResourceService::class, function ($app) {
            return new ResourceService($app->make(ResourceRepositoryInterface::class), $app->make(ReservationRepositoryInterface::class));
        });



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
