<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;
use PHPHtmlParser\Dom;

class LinksScanner extends Scanner
{

    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $content = $model->getSeoAttribute('content');

        $dom = new Dom;
        $dom->loadStr($content);
        $report = Result::make('Links Scanner');

        $tags = $dom->find('a');
        $countDeadLinks = 0;
        $countInternalLinks = 0;
        $countExternalLinks = 0;

        if ($tags->count() === 0) {
            return $report->hasPassed('There are not any links within your content.');
        }

        $baseHost = parse_url(url('/'), PHP_URL_HOST);

        foreach ($tags as $tag) {
            $link = $tag->getAttribute('href');
            if (empty($link) || $link === '#') {
                $countDeadLinks++;
                continue;
            }

            if ($baseHost === parse_url($link, PHP_URL_HOST)) {
                $countInternalLinks++;
                continue;
            }

            $countExternalLinks++;
        }

        $meta = [
            'dead' => $countDeadLinks,
            'internal' => $countInternalLinks,
            'external' => $countExternalLinks,
        ];

        return $report->meta($meta)
            ->hasPassed(__('There are :internal internal links, :external external links and :dead dead links', $meta));
    }
}
