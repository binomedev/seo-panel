<?php


namespace Binomedev\SeoPanel\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package Binomedev\SeoPanel\Models
 */
class NotFoundLog extends Model
{

    protected $table = 'seo_not_found_logs';

    protected $fillable = [
        'uri',
        'ip',
        'referer',
        'user_agent',
        'hits',
    ];
}
