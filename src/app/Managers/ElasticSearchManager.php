<?php

namespace App\Managers;

use App\Clients\ElasticSearchClient;
use App\Data\ProductElasticDTO;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearchManager
{
    public function __construct(
        protected ElasticSearchClient $elasticSearchClient
    )
    {}

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function index(ProductElasticDTO $data): void
    {
        $this->elasticSearchClient->getClient()->index($data->toArray());
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $params): array
    {
        $response = $this->elasticSearchClient->getClient()->search($params);
        return $response->asArray();
    }
}
