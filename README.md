# Laravel SEO Sorcery

A handy panel to help improve the SEO of your application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binomedev/seo_panel.svg?style=flat-square)](https://packagist.org/packages/binomedev/seo_panel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/binomedev/seo_panel/run-tests?label=tests)](https://github.com/binomedev/seo_panel/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/binomedev/seo_panel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/binomedev/seo_panel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/binomedev/seo_panel.svg?style=flat-square)](https://packagist.org/packages/binomedev/seo_panel)

## Table of Contents
 
1. [Installation]()
1. [Publish Assets]()
1. [Usage]()
    1. [Model Setup]()
    1. [SEO Service Overview]()
    1. [Register Custom Inspector]()
    1. [Register Custom Scanner]()

1. [Middlewares and Black Magic]()
    1. [SetDefaultSeoTags Middleware]()
    1. [EntangleSeoEntity Middleware]()
    1. [InjectSeoTags Middleware]()
1. [Extending]()
1. [Scheduling]()
1. [Roadmap]()


## Installation

### Dependencies

- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
- [artesaos/seotools](https://github.com/artesaos/seotools)

You can install the package via composer:

```bash
composer require binomedev/seo-panel
```

Then run the install command:

```bash
php artisan seo:install
```

### Publish Assets
You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Binomedev\SeoPanel\SeoPanelServiceProvider" --tag="seo-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Binomedev\SeoPanel\SeoPanelServiceProvider" --tag="seo-config"
```

This is the contents of the published config file:

```php
return [
     /*
     * When this is enabled, the meta tags will be generated and injected auto-magically.
     * Set this to false if you want to manually generate the tags.
     */
    'auto_inject_enabled' => env('SEO_AUTO_INJECT', true),

    /*s
     * The 'You shall not pass' for this package.
     *
     * Set the paths where you don't want to generate seo tags.
     */
    'inject_except' => [
        'telescope*',
        'horizon*',
        'nova*',
    ],
];
```

## Usage

### Model Setup
 
Add the **CanBeSeoAnalyzed** interface and the **HasSeo** trait to any model that you would like to be used for SEO analyzing.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Binomedev\SeoPanel\CanBeSeoAnalyzed;
use Binomedev\SeoPanel\Traits\HasSeo;

class Post extends Model implements CanBeSeoAnalyzed
{
    use HasFactory, HasSeo; 
}
```

Aand... in theory, that should be all of it. 
Well, there is more to it if you really want to get your hands dirty.

## Middlewares & Black Magic :fire:

By default, you don't have to add any middlewares as long as the 'auto_inject_enabled' is set to **true**.
However, if magic scares you, you should set it to **false** and add any middlewares that fits you.

It can be set in the .env file, there is no need to publish the config file.

```dotenv
SEO_AUTO_INJECT=false
```

Add middlewares in order to set the meta tags automatically.

```php
[
    // App\Http\Kernel.php.
    'web' => [
        //...
        \Binomedev\SeoPanel\Http\Middleware\SetDefaultSeoTags::class,
        \Binomedev\SeoPanel\Http\Middleware\EntangleSeoEntity::class,
        \Binomedev\SeoPanel\Http\Middleware\InjectSeoTags::class,
        //...
    ]
];
```

Let's break it down, shall we? 

#### SetDefaultSeoTags Middleware

Starting with **SetDefaultSeoTags::class**, this middleware, sets the default meta tags from the *seo_options* table. 
Such as default title (Site Name, company name, etc), title separator and a description.

Any of these can be overridden within any controller method. Example:

```php

use App\Http\Controllers\Controller;
// Make sure to import the SEOTools;
use Artesaos\SEOTools\Traits\SEOTools; 

class PageController extends Controller {
    use SEOTools;
    
    public function dashboard()
    { 
        // Use the following method chain to set a description.
        $this->seo()->setDescription('New description.');
        // Or
        \SeoTools::setDescription('Some description using the facade.');
    
        return view('dashboard');
    }
}
```

You can find out more about the [SEOTools here](https://github.com/artesaos/seotools).

#### EntangleSeoEntity Middleware

Some meta tags, including the description, are overridden by the *'EntangleSeoEntity::class'* middleware.
Which can be used for single and groups of routes or, as suggested above, using the web middleware.

If you want to do it the manual way, you can use the following syntax:

```php
// In some controller
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use App\Models\Post;

class PageController extends Controller {
    use SEOTools; // <--- Remember to use the trait.
    
    public function show(Post $post)
    { 
        // ...
     
        $this->seo()->setTitle($post->seoMeta->title);
        $this->seo()->setDescription($post->seoMeta->description);
        $this->seo()->metatags()->setKeywords($post->seoMeta->keywords);
        
        // ... 
    }
}

```

#### InjectSeoTags Middleware

'InjectSeoTags::class' middleware is responsible for generating and actually injecting the html in the head section. 
However, 95% of this is just trying to figure it out if and where should inject the content. 
If you do not wish for this overhead, then you can simply remove the middleware and just paste following line:

```html
<!-- layouts/app.blade.php-->
<head>
    <!-- ... -->
    {{ SEOTools::generate($minify = true) }}
    <!-- ... -->
</head>
```

### Extending

todo

#### Inspectors

Inspectors are used to search for generic issues that may impact seo, such as: not using https, missing sitemap, speed
loading, etc

#### Scanners


Scanners are used to search for seo issues within a resource/model's fields, such as: title, slug, content, etc.


### Schedules

```php
// app/Console/Kernel.php
function schedule(Schedule $schedule)
{
    //...
    $schedule->command('seo:generate-sitemap')->daily();
    // ...
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Roadmap

### Generic Features

- [ ] Google Analytics Integration (Made Easy)
- [X] Generate SEO MetaTags
- [ ] Automated technical SEO improvements, like canonical URLs and meta tags.
- [ ] Advanced XML sitemaps; making it easy for Google to understand your site structure.
- [ ] Title and meta description templating, for better branding and consistent snippets in the search results.
- [ ] An in-depth Schema.org integration that will increase your chance of getting rich results, by helping search
  engines to understand your content.
- [ ] Full control over site breadcrumbs, so that users and search engines always know where they are.
- [X] Faster loading times for your whole website, due to an innovative way of managing data in Laravel.
- [ ] Ping Search Engines: Automatically notify Google & Bing when a sitemap gets updated.

### Content Writing

- [ ] SEO analysis: an invaluable tool while writing SEO-friendly content with the right (focus) keyphrases in mind.
- [ ] Readability analysis: ensures that humans and search engines can read and understand your content.
- [ ] Full language support for: English, German, French, Dutch, Spanish, Italian, Russian, Indonesian, Polish,
  Portuguese, Arabic, Swedish, Hebrew, Hungarian and Turkish.
- [ ] A Google preview, which shows what your listings will look like in the search results. Even on mobile devices!
- [ ] Innovative Schema blocks for the WordPress block editor, so that your FAQ and HowTo content can be shown directly
  in the search results. Plus a breadcrumbs block to guide your users.
- [ ] Internal linking blocks to easily improve the structure of your content. Easily add a table of contents block, a
  related links block, a subpages block, or siblings block! Plus, we’ll keep adding these easy-to-add blocks to improve
  your site structure.
- [ ] Social previews to show you how your content will be shown on Twitter and Facebook.
- [ ] The Insights tool that shows you what your text focuses on. This way you can keep your article in line with your
  keyphrases.
- [ ] Optimize your content for synonyms and related keyphrases.
- [ ] Optimize your article for different word forms of your keyphrases, as the singular and plural. But also different
  verb forms, synonyms, and related keyphrases. This makes for more natural content!
- [ ] Automatic internal linking suggestions: write your article and get automatic suggested posts to link to!
- [ ] An orphaned content filter to detect posts that have no links pointing towards them!

### Content/Structure Inspections

- [ ] Common Keywords
- [X] SEO Title
- [X] SEO Description
- [ ] H1 Heading
- [ ] H2 Heading
- [ ] Image ALT Attributes
- [X] Keywords in Title & Description
- [ ] Links Ratio
- [ ] Site Tagline
- [ ] Permalink Structure
- [X] Focus Keywords
- [X] Post Titles Missing Focus Keywords

### Advanced SEO - Sanity Checks

- [ ] Search Preview
- [ ] Mobile Search Preview
- [ ] Mobile Snapshot
- [ ] Canonical Tag
- [ ] Noindex Meta
- [ ] WWW Canonicalization
- [ ] OpenGraph Meta
- [ ] Robots.txt
- [ ] Schema Meta Data
- [ ] Search Console
- [X] Check if sitemaps exists
- [X] Secure Connection: Check if website is configured to use https

### Performance Checks

- [ ] Image Headers Expire
- [ ] Minify CSS
- [ ] Minify Javascript
- [ ] Page Objects
- [ ] Page Size
- [ ] Response Time

### Service

- [ ] Run scans on our server using the API. This helps people with low-end servers (Shared Hosting) or people who don't
  have an admin panel.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Codrin Axinte](https://github.com/codrin-axinte)
- [All Contributors](../../contributors)

## Research

- [Rank Math Demo](https://demo.rankmath.com/wp-login.php)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
