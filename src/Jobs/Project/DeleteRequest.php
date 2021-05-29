<?php


namespace Binomedev\SeoPanel\Jobs\Project;


use Binomedev\SeoPanel\DataObjects\EntityDTO;
use Binomedev\SeoPanel\DataObjects\ProjectDTO;
use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;

class DeleteRequest extends Job
{

    private ProjectDTO $project;

    /**
     * CreateEntityRequest constructor.
     * @param ProjectDTO $project
     */
    public function __construct(ProjectDTO $project)
    {
        $this->project = $project;
    }

    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->delete("/projects/{$this->project->name}");
    }
}
