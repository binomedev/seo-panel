<?php

namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Commands\{GenerateSitemapCommand, InspectCommand, InstallCommand, PingCommand};
use Binomedev\SeoPanel\Http\Middleware\{EntangleSeoEntity, InjectSeoTags, SetDefaultSeoTags};
use Illuminate\Contracts\Http\Kernel;
use Spatie\LaravelPackageTools\{Package, PackageServiceProvider};

class SeoPanelServiceProvider extends PackageServiceProvider
{

    protected $commands = [
        InspectCommand::class,
        GenerateSitemapCommand::class,
        InstallCommand::class,
        PingCommand::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('seo')
            ->hasConfigFile()
            ->hasViews()
            //->hasRoute('web')
            ->hasMigrations([
                'create_seo_options_table',
                'create_seo_meta_table',
                'create_seo_reports_table',
                // 'create_seo_not_found_logs_table',
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
        $this->app->singleton(Sorcery::class, function () {
            $config = config('services.seo_sorcery');

            return new Sorcery($config['token'], $config['url']);
        });
    }
}
