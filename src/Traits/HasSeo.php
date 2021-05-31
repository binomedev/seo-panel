<?php


namespace Binomedev\SeoPanel\Traits;

use Binomedev\SeoPanel\{Jobs\Entity\CreateRequest,
    Jobs\Entity\DeleteRequest,
    Jobs\Entity\UpdateRequest,
    Models\Meta,
    Models\Report
};
use CodrinAxinte\SorceryCore\DataObjects\EntityData;
use Illuminate\Database\{Eloquent\Model, Eloquent\Relations\MorphMany, Eloquent\Relations\MorphOne};
use Illuminate\Support\Str;
use PHPHtmlParser\Exceptions\Tag\AttributeNotFoundException;

/**
 * Trait HasSeo
 * @package Binomedev\SeoPanel\Traits
 * @mixin Model
 */
trait HasSeo
{
    private array $seoAttributesMap = [
        'title' => 'title',
        'slug' => 'slug',
        'content' => 'content',
    ];

    public static function bootHasSeo()
    {
        static::created(function ($entity) {
            $entity->seo()->create([
                'title' => $entity->getSeoAttributeValue('title'),
                'description' => self::makeDescriptionFromContent($entity->getSeoAttributeValue('content')),
                'schema' => 'article',
            ]);

            dispatch(new CreateRequest($entity->toDataTransferObject()));
        });

        static::updated(function ($entity) {
            dispatch(new UpdateRequest($entity->toDataTransferObject()));
        });

        static::deleting(function ($entity) {

            dispatch(new DeleteRequest($entity->toDataTransferObject()));

            $entity->seo()->delete();
            $entity->seoReports()->delete();
        });
    }

    private static function makeDescriptionFromContent($content, $limit = 160): ?string
    {
        // Avoid doing all strips and limits if content is empty
        if (empty($content)) {
            return null;
        }

        $content = strip_tags(htmlspecialchars_decode($content));

        return Str::limit($content, $limit);
    }

    public function toDataTransferObject(): EntityData
    {
        // TODO: Refactor this into a dedicated class like a Transformer or Resource.
        $seo = $this->seo;

        return new EntityData([
            'external_id' => $this->getKey(),
            'title' => optional($seo)->title ?? $this->getSeoAttributeValue('title'),
            'content' => $this->getSeoAttributeValue('content'),
            'slug' => $this->getSeoAttributeValue('slug'),
            'description' => optional($seo)->description,
            'keywords' => optional($seo)->keywordsList,
            'schema' => optional($seo)->schema,
            'url' => $this->getShowUrl(),
            'custom' => $this->serializeCustomAttributes(),
        ]);
    }

    public function getSeoAttributeValue($field)
    {
        return $this->getAttribute($this->getSeoAttributeName($field));
    }

    public function getSeoAttributeName($field)
    {
        if (!array_key_exists($field, $this->seoAttributesMap)) {
            throw new AttributeNotFoundException("The seo '{$field}' attribute does not exist.");
        }

        return $this->seoAttributesMap[$field];
    }

    private function serializeCustomAttributes(): ?array
    {
        $customAttributes = $this->mapSeoCustomAttributes();

        if (empty($customAttributes)) {
            return null;
        }

        return collect($customAttributes)
            ->mapWithKeys(
                fn($attributeName) => [$attributeName => $this->getAttribute($attributeName)]
            )
            ->toArray();
    }

    public function mapSeoCustomAttributes(): array
    {
        return [];
    }

    public function seoReports(): MorphMany
    {
        return $this->morphMany(Report::class, 'seoable');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Meta::class, 'seoable');
    }

    protected function setSeoField($field, $value): static
    {
        $this->seoAttributesMap[$field] = $value;

        return $this;
    }
}
