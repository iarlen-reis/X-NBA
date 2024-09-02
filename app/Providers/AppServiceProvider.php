<?php

namespace App\Providers;

use App\Repositories\Contracts\AverageRepositoryInterface;
use App\Repositories\Contracts\MatcheRepositoryInterface;
use App\Repositories\Contracts\MatchTeamRepositoryInterface;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Implementations\AverageRepository;
use App\Repositories\Implementations\MatcheRepository;
use App\Repositories\Implementations\MatchTeamRepository;
use App\Repositories\Implementations\PlayerRepository;
use App\Repositories\Implementations\TeamRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TeamRepositoryInterface::class,
            TeamRepository::class,
        );

        $this->app->bind(
            PlayerRepositoryInterface::class,
            PlayerRepository::class,
        );

        $this->app->bind(
            AverageRepositoryInterface::class,
            AverageRepository::class,
        );

        $this->app->bind(
            MatcheRepositoryInterface::class,
            MatcheRepository::class,
        );

        $this->app->bind(
            MatchTeamRepositoryInterface::class,
            MatchTeamRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
