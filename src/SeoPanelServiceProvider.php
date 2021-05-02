<?php

namespace Binomedev\SeoPanel;

use Binomedev\SeoPanel\Commands\GenerateSitemapCommand;
use Binomedev\SeoPanel\Commands\InspectCommand;
use Binomedev\SeoPanel\Inspectors\HttpsInspector;
use Binomedev\SeoPanel\Inspectors\SitemapInspector;
use Binomedev\SeoPanel\Scanners\ContentMinLengthScanner;
use Binomedev\SeoPanel\Scanners\DescriptionLengthScanner;
use Binomedev\SeoPanel\Scanners\FocusKeywordsPresenceScanner;
use Binomedev\SeoPanel\Scanners\SchemaExistsScanner;
use Binomedev\SeoPanel\Scanners\SlugLengthScanner;
use Binomedev\SeoPanel\Scanners\TitleLengthScanner;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoPanelServiceProvider extends PackageServiceProvider
{
    protected $inspectors = [
        SitemapInspector::class,
        HttpsInspector::class,
    ];

    protected $commands = [
        InspectCommand::class,
        GenerateSitemapCommand::class,
        // PublishCommand::class,
    ];

    protected $scanners = [
        TitleLengthScanner::class,
        DescriptionLengthScanner::class,
        SlugLengthScanner::class,
        ContentMinLengthScanner::class,
        SchemaExistsScanner::class,
        FocusKeywordsPresenceScanner::class,
    ];


    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('seo')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_seo_options_table',
                'create_seo_meta_table'
            ])
            ->hasCommands($this->commands);
    }

    public function packageBooted()
    {
        SeoFacade::useInspector($this->inspectors);
        SeoFacade::useScanner($this->scanners);
    }

    public function packageRegistered()
    {
        $this->app->singleton(Seo::class);
    }
}
