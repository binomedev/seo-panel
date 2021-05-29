<?php


namespace Binomedev\SeoPanel\Jobs\Project;


use Binomedev\SeoPanel\DataObjects\EntityDTO;
use Binomedev\SeoPanel\DataObjects\ProjectDTO;
use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;

class UpdateRequest extends Job
{
    private ProjectDTO $project;

    /**
     * UpdateRequest constructor.
     * @param ProjectDTO $project
     */
    public function __construct(ProjectDTO $project)
    {
        $this->project = $project;
    }


    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->put('/projects', $this->project->toArray());
    }
}
