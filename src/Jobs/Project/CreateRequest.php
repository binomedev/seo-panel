<?php


namespace Binomedev\SeoPanel\Jobs\Project;


use Binomedev\SeoPanel\DataObjects\EntityDTO;
use Binomedev\SeoPanel\DataObjects\ProjectDTO;
use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;

class CreateRequest extends Job
{
    private ProjectDTO $project;

    /**
     * CreateRequest constructor.
     * @param ProjectDTO $project
     */
    public function __construct(ProjectDTO $project)
    {
        $this->project = $project;
    }


    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->post(
            '/projects',
            $this->project->toArray(),
        );
    }
}
