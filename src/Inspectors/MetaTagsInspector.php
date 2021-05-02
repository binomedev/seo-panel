<?php


namespace Binomedev\SeoPanel\Inspectors;


use App\Models\Post;
use Binomedev\SeoPanel\Inspector;
use Binomedev\SeoPanel\Report;
use Binomedev\SeoPanel\SeoFacade;

class MetaTagsInspector extends Inspector
{

    function inspect(): Report
    {
        // Check for default title
        // Check for default description (tagline)
        // Check for default keywords
    }
}
