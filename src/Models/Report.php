<?php


namespace Binomedev\SeoPanel\Models;


use CodrinAxinte\SorceryCore\ValueObjects\Score;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const TYPE_ANALYSIS = 'analysis';
    const TYPE_INSPECTION = 'inspection';

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

    /**
     * @param $type
     * @throws \Exception
     * @deprecated
     */
    protected function checkIfSeverityAllowed($type)
    {
        Score::validateSeverity($type);
    }
}
