<?php

namespace App\Pipelines\Stages;

use App\Actions\UpdateCacheAction;
use App\Data\ProductDTO;
use Closure;

class UpdateCache
{
    public function __construct(protected UpdateCacheAction $updateCacheAction)
    {}

    public function handle(ProductDTO $productDTO, Closure $next): ProductDTO
    {
        $this->updateCacheAction->execute($productDTO);
        return $next($productDTO);
    }
}
