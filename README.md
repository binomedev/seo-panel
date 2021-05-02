# Laravel SEO Panel

A handy panel to help improve the SEO of your application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binomedev/seo_panel.svg?style=flat-square)](https://packagist.org/packages/binomedev/seo_panel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/binomedev/seo_panel/run-tests?label=tests)](https://github.com/binomedev/seo_panel/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/binomedev/seo_panel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/binomedev/seo_panel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/binomedev/seo_panel.svg?style=flat-square)](https://packagist.org/packages/binomedev/seo_panel)

## Installation

You can install the package via composer:

```bash
composer require binomedev/seo_panel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Binomedev\SeoPanel\SeoPanelServiceProvider" --tag="seo_panel-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Binomedev\SeoPanel\SeoPanelServiceProvider" --tag="seo_panel-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$seo_panel = new Binomedev\SeoPanel();
echo $seo_panel->echoPhrase('Hello, Spatie!');
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
- [ ] Generate SEO MetaTags
- [ ] Automated technical SEO improvements, like canonical URLs and meta tags.
- [ ] Advanced XML sitemaps; making it easy for Google to understand your site structure.
- [ ] Title and meta description templating, for better branding and consistent snippets in the search results.
- [ ] An in-depth Schema.org integration that will increase your chance of getting rich results, by helping search engines
  to understand your content.
- [ ] Full control over site breadcrumbs, so that users and search engines always know where they are.
- [X] Faster loading times for your whole website, due to an innovative way of managing data in Laravel.
- [ ] Ping Search Engines: Automatically notify Google & Bing when a sitemap gets updated.

### Content Writing

- [ ] SEO analysis: an invaluable tool while writing SEO-friendly content with the right (focus) keyphrases in mind.
- [ ] Readability analysis: ensures that humans and search engines can read and understand your content.
- [ ] Full language support for: English, German, French, Dutch, Spanish, Italian, Russian, Indonesian, Polish, Portuguese,
  Arabic, Swedish, Hebrew, Hungarian and Turkish.
- [ ] A Google preview, which shows what your listings will look like in the search results. Even on mobile devices!
- [ ] Innovative Schema blocks for the WordPress block editor, so that your FAQ and HowTo content can be shown directly in
  the search results. Plus a breadcrumbs block to guide your users.
- [ ] Internal linking blocks to easily improve the structure of your content. Easily add a table of contents block, a
  related links block, a subpages block, or siblings block! Plus, we’ll keep adding these easy-to-add blocks to improve
  your site structure.
- [ ] Social previews to show you how your content will be shown on Twitter and Facebook.
- [ ] The Insights tool that shows you what your text focuses on. This way you can keep your article in line with your
  keyphrases.
- [ ] Optimize your content for synonyms and related keyphrases.
- [ ] Optimize your article for different word forms of your keyphrases, as the singular and plural. But also different verb
  forms, synonyms, and related keyphrases. This makes for more natural content!
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

## Usage

## Structure

### Inspectors

Inspectors are used to search for generic issues that may impact seo, such as: not using https, missing sitemap, speed loading, etc 

### Scanners 

Scanners are used to search for seo issues within a resource content.


### Dependencies

- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
- [artesaos/seotools](https://github.com/artesaos/seotools)

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
