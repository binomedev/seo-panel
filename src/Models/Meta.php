<?php


namespace Binomedev\SeoPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'seo_meta';

    protected $fillable = ['title', 'description', 'keywords', 'image', 'schema'];

    public function seoable()
    {
        return $this->morphTo();
    }

    public function getKeywordsListAttribute()
    {
        return explode(',', $this->keywords);
    }
}
