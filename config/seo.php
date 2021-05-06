<?php

use Binomedev\SeoPanel\Inspectors\{HttpsInspector, SitemapInspector};
use Binomedev\SeoPanel\Scanners\{ContentMinLengthScanner,
    DescriptionLengthScanner,
    FocusKeywordsPresenceScanner,
    SchemaExistsScanner,
    SlugLengthScanner,
    TitleLengthScanner
};

return [

    /*
     * Black magic, night coder
     * She haunts me like no other
     * Nobody told me code is pain
     *
     * Black magic, dark water (deep reference to coffee)
     * Surrounds me like no other
     * She's got my heart in chains
     */

    /**
     * When this is enabled, the meta tags will be generated and injected auto-magically.
     * Set this to false if you want to manually generate the tags.
     */
    'auto_inject_enabled' => env('SEO_AUTO_INJECT', true),

    /**
     * The 'You shall not pass' for this package.
     *
     * Set the paths where you don't want to generate seo tags.
     */
    'inject_except' => [
        'telescope*',
        'horizon*',
        'nova*',
    ],


    /**
     *
     */
    'inspectors' => [
        SitemapInspector::class,
        HttpsInspector::class,
    ],

    /**
     *
     */
    'scanners' => [
        TitleLengthScanner::class,
        DescriptionLengthScanner::class,
        SlugLengthScanner::class,
        ContentMinLengthScanner::class,
        SchemaExistsScanner::class,
        FocusKeywordsPresenceScanner::class,
    ],
];
