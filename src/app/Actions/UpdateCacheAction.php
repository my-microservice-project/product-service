<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Enums\CacheEnum;
use Illuminate\Support\Facades\Cache;

class UpdateCacheAction
{
    public function execute(ProductDTO $productDTO): void
    {
        Cache::put(
            CacheEnum::PRODUCT->getValue().$productDTO->id,
            $productDTO->toArray(),
            now()->addHours(CacheEnum::PRODUCT->getTTL())
        );
    }
}
