<?php

namespace App\Clients;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticSearchClient
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([config('elasticsearch.host').':'.config('elasticsearch.port')])
            ->build();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
