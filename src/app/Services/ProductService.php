<?php

namespace App\Services;


use App\Repositories\Contracts\ProductSearchRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;
use App\Data\ProductSearchDTO;
use App\Jobs\ProcessProductJob;
use Illuminate\Support\Collection;
use App\Enums\CacheEnum;
use App\Enums\QueueEnum;
use App\Data\ProductDTO;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected ProductSearchRepositoryInterface $productSearchRepository
    )
    {}

    public function enqueueProducts(DataCollection $products): void
    {
        $products->each(function (ProductDTO $productDTO): void {
            dispatch(new ProcessProductJob($productDTO))->onQueue(QueueEnum::PRODUCT_PROCESS->getValue());
        });
    }

    public function search(ProductSearchDTO $toDTO): Collection
    {
        return $this->productSearchRepository->findProducts($toDTO);
    }

    public function getProduct(int $productId): ProductDTO
    {
        $product = $this->productRepository->getProductById($productId);
        $product->stock = Cache::get(CacheEnum::STOCK->getValue().$product->id, 0);

        return $product;
    }

    public function getProductByIdOnCache(int $productId): ProductDTO
    {
        return Cache::remember(CacheEnum::PRODUCT->getValue().$productId, now()->addMinutes(5), function () use ($productId) {
            return $this->getProduct($productId);
        });
    }
}
