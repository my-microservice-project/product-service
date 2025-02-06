<?php

namespace App\Services;

use App\Data\ProductDTO;
use App\Data\ProductSearchDTO;
use App\Enums\CacheEnum;
use App\Enums\QueueEnum;
use App\Jobs\ProcessProductJob;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ProductSearchRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelData\DataCollection;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository, protected ProductSearchRepositoryInterface $productSearchRepository)
    {}

    public function enqueueProducts(DataCollection $products): void
    {
        $products->each(function (ProductDTO $productDTO): void {
            dispatch(new ProcessProductJob($productDTO))->onQueue(QueueEnum::PRODUCT_PROCESS->getValue());
        });
    }

    public function search(ProductSearchDTO $toDTO): Collection
    {
        return $this->productSearchRepository->search($toDTO);
    }

    public function getProductById(int $productId): ProductDTO
    {
        $product = $this->productRepository->getProductById($productId);
        $product->stock = Cache::get(CacheEnum::STOCK->getValue().$product->id, 0);

        return $product;
    }
}
