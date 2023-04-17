<?php

namespace App\Providers;

use App\Services\ImagesRepository;
use App\Services\Interfaces\ImagesRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ImagesRepositoryInterface::class => ImagesRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
