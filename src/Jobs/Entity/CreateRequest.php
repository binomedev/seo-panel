<?php


namespace Binomedev\SeoPanel\Jobs\Entity;


use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;
use CodrinAxinte\SorceryCore\DataObjects\EntityData;

class CreateRequest extends Job
{
    protected EntityData $entity;

    /**
     * CreateRequest constructor.
     * @param EntityData $entity
     */
    public function __construct(EntityData $entity)
    {
        $this->entity = $entity;
    }


    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->post(
            '/entities',
            $this->entity->toArray(),
        );

        $this->debugResponse($response);

        //auth()->user()->notify(new EntityUpdated($response->body()));
    }
}
