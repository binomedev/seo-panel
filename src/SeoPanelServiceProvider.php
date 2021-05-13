<?php

namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Commands\{GenerateSitemapCommand, InspectCommand, InstallCommand};
use Binomedev\SeoPanel\Http\Middleware\{EntangleSeoEntity, InjectSeoTags, SetDefaultSeoTags};
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Spatie\LaravelPackageTools\{Package, PackageServiceProvider};

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
                'create_seo_reports_table',
            ])
            ->hasCommands($this->commands);
    }

    public function packageBooted()
    {
        if ($this->app->runningInConsole() && !$this->app['config']['seo.auto_inject_enabled']) {
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
