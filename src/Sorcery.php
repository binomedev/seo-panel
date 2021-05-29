<?php


namespace Binomedev\SeoPanel;


use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;

class Sorcery
{

    private string $token;
    private Fluent $user;
    private string $url;

    /**
     * SorceryClient constructor.
     * @param string $token
     * @param string $url
     */
    public function __construct(string $token, string $url)
    {
        $this->token = $token;
        $this->url = $url;
    }

    public function user($force = false): Fluent
    {
        if (!$this->user || $force) {
            $response = $this->request()->get('/user');

            $this->user = new Fluent($response->json());
        }

        return $this->user;
    }

    public function request(): PendingRequest
    {
        $client_id = config('services.seo_sorcery.client_id');
        return Http::baseUrl($this->url . "/projects/$client_id")
            ->withToken($this->token)
            ->acceptJson();
    }

    public function post(...$args): PromiseInterface|Response
    {
        return $this->request()->post(...$args);
    }

    public function get(...$args): PromiseInterface|Response
    {
        return $this->request()->get(...$args);
    }

    public function put(...$args): PromiseInterface|Response
    {
        return $this->request()->put(...$args);
    }

    public function delete(...$args): PromiseInterface|Response
    {
        return $this->request()->delete(...$args);
    }
}
