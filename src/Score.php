<?php


namespace Binomedev\SeoPanel;


class Score
{
    private $scores =  [
        'h1_heading'          => 5,
        'h2_headings'         => 2,
        'img_alt'             => 4,
        'keywords_meta'       => 5,
        'links_ratio'         => 3,
        'title_length'        => 4,
        'permalink_structure' => 7,
        'focus_keywords'      => 3,
        'post_titles'         => 4,

        // Advanced SEO.
        'canonical'           => 5,
        'noindex'             => 7,
        'non_www'             => 4,
        'opengraph'           => 2,
        'robots_txt'          => 3,
        'schema'              => 3,
        'sitemaps'            => 3,
        'search_console'      => 1,

        // Performance.
        'image_header'        => 3,
        'minify_css'          => 2,
        'minify_js'           => 1,
        'page_objects'        => 2,
        'page_size'           => 3,
        'response_time'       => 3,

        // Security.
        'directory_listing'   => 1,
        'safe_browsing'       => 8,
        'ssl'                 => 7,
    ];
}
