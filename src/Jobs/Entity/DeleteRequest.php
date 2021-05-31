<?php


namespace Binomedev\SeoPanel\Jobs\Entity;



use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;
use CodrinAxinte\SorceryCore\DataObjects\EntityData;

class DeleteRequest extends Job
{

    private EntityData $entity;

    /**
     * CreateEntityRequest constructor.
     * @param EntityData $entity
     */
    public function __construct(EntityData $entity)
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
