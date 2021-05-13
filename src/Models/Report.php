<?php


namespace Binomedev\SeoPanel\Models;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const TYPE_ANALYSIS = 'analysis';
    const TYPE_INSPECTION = 'inspection';

    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';
    protected static array $severities = [
        self::SEVERITY_LOW,
        self::SEVERITY_MEDIUM,
        self::SEVERITY_HIGH,
        self::SEVERITY_CRITICAL,
    ];

    protected $table = 'seo_reports';
    protected $fillable = [
        'severity',
        'results',
        'type',
        'score',
    ];
    protected $casts = [
        'results' => 'array',
        'score' => 'int',
    ];

    public function seoable()
    {
        return $this->morphTo();
    }

    protected function checkIfSeverityAllowed($type)
    {
        $allowedTypes = static::$severities;
        if (in_array($type, $allowedTypes)) {
            return;
        }

        $list = implode(', ', $allowedTypes);

        throw new \Exception('Severity type is not supported. It must be one of the following: ' . $list);
    }
}
