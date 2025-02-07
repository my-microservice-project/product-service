<?php

namespace App\Pipelines\Stages;

use App\Actions\SyncStockAction;
use App\Data\ProductDTO;
use Closure;

class SyncStock
{
    public function __construct(
        protected SyncStockAction $action
    )
    {}

    public function handle(ProductDTO $productDTO, Closure $next): ProductDTO
    {
        $this->action->execute($productDTO);
        return $next($productDTO);
    }
}
