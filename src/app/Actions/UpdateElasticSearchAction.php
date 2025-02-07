<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Data\ProductElasticDTO;
use App\Enums\ElasticIndexEnum;
use App\Managers\ElasticSearchManager;
use Elastic\Elasticsearch\Exception\{ClientResponseException, MissingParameterException, ServerResponseException};

class UpdateElasticSearchAction
{
    public function __construct(protected ElasticSearchManager $elasticSearchManager)
    {}

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function execute(ProductDTO $productDTO): void
    {
        $this->elasticSearchManager->index(new ProductElasticDTO(
            index: ElasticIndexEnum::PRODUCTS->getValue(),
            id: $productDTO->id,
            body: $productDTO
        ));
    }
}
