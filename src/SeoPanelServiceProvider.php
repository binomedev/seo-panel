<?php

namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Commands\GenerateSitemapCommand;
use Binomedev\SeoPanel\Commands\InspectCommand;
use Binomedev\SeoPanel\Commands\InstallCommand;
use Binomedev\SeoPanel\Commands\PublishCommand;
use Binomedev\SeoPanel\Http\Middleware\EntangleSeoEntity;
use Binomedev\SeoPanel\Http\Middleware\InjectSeoTags;
use Binomedev\SeoPanel\Http\Middleware\SetDefaultSeoTags;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoPanelServiceProvider extends PackageServiceProvider implements DeferrableProvider
{

    protected $commands = [
        InspectCommand::class,
        GenerateSitemapCommand::class,
        InstallCommand::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('seo')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_seo_options_table',
                'create_seo_meta_table',
            ])
            ->hasCommands($this->commands);
    }

    public function packageBooted()
    {
        $this->registerMiddlewares();
    }

    private function registerMiddlewares()
    {
        if ($this->app->runningInConsole() && !config('seo.auto_inject_enabled')) {
            return;
        }

        $kernel = $this->app[Kernel::class];;

        $kernel->appendMiddlewareToGroup('web', SetDefaultSeoTags::class);
        $kernel->appendMiddlewareToGroup('web', EntangleSeoEntity::class);
        $kernel->appendMiddlewareToGroup('web', InjectSeoTags::class);
    }

    public function packageRegistered()
    {
        $this->app->singleton(Seo::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Seo::class];
    }
}
