<?php


namespace Binomedev\SeoPanel\Scanners;


use Binomedev\SeoPanel\Contracts\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Result;
use Binomedev\SeoPanel\Scanner;
use PHPHtmlParser\Dom;

class ImageAltScanner extends Scanner
{

    public function scan(CanBeSeoAnalyzed $model): Result
    {
        $content = $model->getSeoAttribute('content');
        $report = Result::make('Image Alt');

        $dom = new Dom;
        $dom->loadStr($content);
        $images = $dom->find('img');

        $countEmpty = 0;

        if ($images->count() === 0) {
            return $report->hasPassed(__('There are no images.'));
        }

        foreach ($images as $image) {
            $altAttribute = $image->getAttribute('alt');

            if (empty($altAttribute)) {
                $countEmpty++;
            }
        }

        if ($countEmpty === 0) {
            $report->hasPassed(__('Great! All images have an alt text.'));
        }


        return $report->hasFailed(__('You have :count images with an empty alt attribute.', ['count' => $countEmpty]));
    }
}
