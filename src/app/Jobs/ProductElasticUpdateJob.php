<?php

namespace App\Jobs;

use Elastic\Elasticsearch\Exception\{ClientResponseException, MissingParameterException, ServerResponseException};
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Actions\UpdateElasticSearchAction;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\ProductService;

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
        $product = $productService->getProduct($this->productId);
        $updateElasticSearchAction->execute($product);
    }
}
