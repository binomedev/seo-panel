<?php


namespace Binomedev\SeoPanel\DataObjects;


use Spatie\DataTransferObject\DataTransferObject;

class EntityDTO extends DataTransferObject
{
    public string $external_id;
    public string $title;
    public string $slug;
    public ?string $content;
    public ?string $schema;
    public ?string $seo_title;
    public ?string $seo_description;
    public array $seo_keywords = [];
}
