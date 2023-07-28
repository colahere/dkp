<?php

namespace Dkp\Seat\SeatDKP;

use Seat\Services\AbstractSeatPlugin;

class DKPServiceProvider extends AbstractSeatPlugin
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->add_routes();
        $this->add_views();
        $this->add_publications();
        $this->add_migrations();
        $this->apply_custom_configuration();
    }


    /**
     * Include the routes.
     */
    public function add_routes()
    {
        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Set the path and namespace for the views.
     */
    public function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'dkp');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/dkp.sidebar.php', 'package.sidebar');

        $this->registerPermissions(
            __DIR__ . '/Config/Permissions/dkp.permissions.php', 'dkp');
    }

    public function add_publications()
    {
        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('web'),
        ]);
    }

    private function add_migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }


    /**
     * Apply any configuration overrides to those config/
     * files published using php artisan vendor:publish.
     *
     * In the case of this service provider, this is mostly
     * configuration items for L5-Swagger.
     */
    public function apply_custom_configuration()
    {
        // Tell L5-swagger where to find annotations. These form
        // part of the controllers themselves.

        // ensure current annotations setting is an array of path or transform into it
        $current_annotations = config('l5-swagger.paths.annotations');
        if (!is_array($current_annotations))
            $current_annotations = [$current_annotations];

        // merge paths together and update config
        config([
            'l5-swagger.paths.annotations' => array_unique(array_merge($current_annotations, [
                __DIR__ . '/Http/Controllers',
            ])),
        ]);
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     * @example SeAT Web
     *
     */
    public function getName(): string
    {
        return 'DKP';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/GhostTraction/sg-dkp.git';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     * @example web
     *
     */
    public function getPackagistPackageName(): string
    {
        return 'sg-dkp';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     * @example eveseat
     *
     */
    public function getPackagistVendorName(): string
    {
        return 'dkp';
    }
}
