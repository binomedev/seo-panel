<?php


namespace Binomedev\SeoPanel\Jobs\Entity;


use App\Notifications\EntityUpdated;
use Binomedev\SeoPanel\DataObjects\EntityDTO;
use Binomedev\SeoPanel\Jobs\Job;
use Binomedev\SeoPanel\Sorcery;
use Illuminate\Support\Facades\Log;

class UpdateRequest extends Job
{
    private EntityDTO $entity;

    /**
     * UpdateRequest constructor.
     * @param EntityDTO $entity
     */
    public function __construct(EntityDTO $entity)
    {
        $this->entity = $entity;
    }


    public function handle(Sorcery $sorcery)
    {
        $response = $sorcery->put('/entities', $this->entity->toArray());

        $this->debugResponse($response);
        //auth()->user()->notify(new EntityUpdated($response->body()));
    }
}
