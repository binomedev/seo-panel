<?php


namespace Binomedev\SeoPanel\Traits;

use Binomedev\SeoPanel\Models\Meta;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasSeo
 * @package Binomedev\SeoPanel\Traits
 * @mixin Model
 */
trait HasSeo
{
    private string $titleField = 'title';
    private string $slugField = 'slug';
    private string $contentField = 'content';

    public function seoMeta()
    {
        return $this->morphOne(Meta::class, 'seoable');
    }

    public function getSeoField($field)
    {
        return $this->{$field . 'Field'};
    }

    protected function setSeoField($field, $value)
    {
        $this->{$field . 'Field'} = $value;

        return $this;
    }

    protected function setSeoTitleField($columnName): static
    {
        return $this->setSeoField('title', $columnName);
    }

    protected function setSeoSlugField($columnName): static
    {
        return $this->setSeoField('slug', $columnName);
    }

    protected function setSeoContentField($columnName): static
    {
        return $this->setSeoField('content', $columnName);
    }
}
