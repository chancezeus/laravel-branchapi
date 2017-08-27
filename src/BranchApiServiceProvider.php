<?php

namespace ChanceZeus\BranchApi;

use ChanceZeus\BranchApi\Commands\CreateLink;
use Illuminate\Support\ServiceProvider;

class BranchApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/branch.php') => config_path('branch.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__ . '/../config/branch.php'), 'branch'
        );

        $this->app->singleton(BranchApi::class, function () {
            if (config('branch.test') === true) {
                return new BranchApi(config('branch.key_test'), config('branch.secret_test'), config('branch.user_id'));
            }

            return new BranchApi(config('branch.key'), config('branch.secret'), config('branch.user_id'));
        });

        $this->app->alias(BranchApi::class, 'branch-api');
    }
}
