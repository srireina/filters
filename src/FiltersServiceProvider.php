<?php

namespace Srireina\Filters;

use Illuminate\Support\ServiceProvider;

class FiltersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
			$this->commands([
				CreateSRFiltersCommand::class,
				NewFiltersCommand::class,
			]);
		}
    }
}
