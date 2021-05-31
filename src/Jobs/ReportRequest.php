<?php


namespace Binomedev\SeoPanel\Jobs;


use Binomedev\SeoPanel\Sorcery;
use CodrinAxinte\SorceryCore\DataObjects\ReportData;

class ReportRequest extends Job
{
    private ReportData $reportData;

    /**
     * ReportRequest constructor.
     * @param ReportData $reportData
     */
    public function __construct(ReportData $reportData)
    {
        $this->reportData = $reportData;
    }


    public function handle(Sorcery $sorcery)
    {
        $sorcery->post('/report', $this->reportData->toArray());
    }
}
