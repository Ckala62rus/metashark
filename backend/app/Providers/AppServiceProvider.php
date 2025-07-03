<?php

namespace App\Providers;

use App\Contracts\BookingRepositoryInterface;
use App\Contracts\BookingServiceInterface;
use App\Contracts\RoomRepositoryInterface;
use App\Contracts\RoomServiceInterface;
use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;
use App\Services\BookingService;
use App\Services\RoomService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(BookingServiceInterface::class, BookingService::class);

        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(RoomServiceInterface::class, RoomService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
