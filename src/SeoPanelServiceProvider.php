<?php

namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Commands\GenerateSitemapCommand;
use Binomedev\SeoPanel\Commands\InspectSeoPanelCommand;
use Binomedev\SeoPanel\Inspectors\HttpsInspector;
use Binomedev\SeoPanel\Inspectors\SitemapInspector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoPanelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('seo_panel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_seo_panel_table')
            ->hasCommands([
                InspectSeoPanelCommand::class,
                GenerateSitemapCommand::class,
            ]);
    }

    public function packageBooted()
    {
        SeoPanelFacade::useInspector([
            SitemapInspector::class,
            HttpsInspector::class,
        ]);
    }

    public function packageRegistered()
    {
        $this->app->singleton(SeoPanel::class);
    }
}
