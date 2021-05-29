<?php


namespace Binomedev\SeoPanel\Jobs\Entity;


use Binomedev\SeoPanel\DataObjects\EntityDTO;
use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;

class DeleteRequest extends Job
{

    private EntityDTO $entity;

    /**
     * CreateEntityRequest constructor.
     * @param EntityDTO $entity
     */
    public function __construct(EntityDTO $entity)
    {
        $this->entity = $entity;
    }

    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->delete("/entities", ['external_id' => $this->entity->external_id]);
        //auth()->user()->notify(new EntityUpdated($response->body()));

        $this->debugResponse($response);
    }
}
