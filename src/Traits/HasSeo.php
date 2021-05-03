<?php


namespace Binomedev\SeoPanel\Traits;

use Binomedev\SeoPanel\Models\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public static function bootHasSeo()
    {
        static::created(function ($entity) {
            $entity->seoMeta()->create([
                'title' => $entity->getSeoAttribute('title'),
                'description' => $entity->makeDescriptionFromContent($entity->getSeoAttribute('content')),
            ]);
        });

        static::deleting(function ($entity) {
            $entity->seoMeta()->delete();
        });
    }

    private static function makeDescriptionFromContent($content, $limit = 160)
    {
        // Avoid doing all strips and limits if content is empty
        if (empty($content)) {
            return null;
        }

        $content = strip_tags(htmlspecialchars_decode($content));

        return Str::limit($content, $limit);
    }

    public function seoMeta()
    {
        return $this->morphOne(Meta::class, 'seoable');
    }

    public function getSeoAttribute($field)
    {
        return $this->getAttribute($this->getSeoField($field));
    }

    public function getSeoField($field)
    {
        return $this->{$field . 'Field'};
    }

    protected function setSeoTitleField($columnName): static
    {
        return $this->setSeoField('title', $columnName);
    }

    protected function setSeoField($field, $value)
    {
        $this->{$field . 'Field'} = $value;

        return $this;
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
