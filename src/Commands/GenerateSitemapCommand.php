<?php


namespace Binomedev\SeoPanel\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemapCommand extends Command
{
    public $signature = 'seo:generate-sitemap';

    public $description = 'Generates a sitemap by crawling the the website.';

    public function handle()
    {
        SitemapGenerator::create(config('app.url'))
            ->writeToFile(public_path('sitemap.xml'))
        ;
        // TODO: Ping search engines with the newly generated sitemap.

        $this->comment('All done');
    }
}
