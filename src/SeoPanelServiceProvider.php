<?php

namespace Binomedev\SeoPanel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Binomedev\SeoPanel\Commands\InstallSeoPanelCommand;

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
            ->hasCommand(InstallSeoPanelCommand::class);
    }
}
