<?php

return [

    /**
     * When this is enabled, the meta tags will be injected auto-magically.
     * Set this to false if you want to manually generate the tags.
     */
    'auto_inject_enabled' => env('SEO_AUTO_INJECT', true),

    'inject_except' => [
        'telescope*',
        'horizon*',
        'nova*',
    ],
];
