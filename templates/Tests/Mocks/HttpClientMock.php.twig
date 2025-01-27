<?php

namespace Tests\Mocks;

use Anteris\Autotask\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Faker\Factory as Faketory;
use Faker\Generator as Faker;

class HttpClientMock extends HttpClient
{
    protected GuzzleClient $client;
    private Faker $faker;

    public function __construct()
    {
        $this->faker = Faketory::create();

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'items' => [],
            ])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $this->client = new GuzzleClient([
            'base_uri' => $this->faker->url(),
            'handler' => $handlerStack,
        ]);
    }
}
