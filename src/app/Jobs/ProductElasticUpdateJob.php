<?php

namespace App\Jobs;

use App\Actions\UpdateElasticSearchAction;
use App\Data\ProductDTO;
use App\Data\ProductElasticDTO;
use App\Enums\ElasticIndexEnum;
use App\Managers\ElasticSearchManager;
use App\Services\ProductService;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class ProductElasticUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public int $productId)
    {}

    /**
     * Execute the job.
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function handle(UpdateElasticSearchAction $updateElasticSearchAction): void
    {
        /** @var ProductService $productService */
        $productService = app(ProductService::class);
        $product = $productService->getProductById($this->productId);
        $updateElasticSearchAction->execute($product);
    }
}
