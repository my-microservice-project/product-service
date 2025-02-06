<?php

namespace App\Pipelines\Stages;

use App\Actions\SyncStockAction;
use App\Data\ProductDTO;
use Closure;

class SyncStock
{

    public function handle(ProductDTO $productDTO, SyncStockAction $action, Closure $next): ProductDTO
    {
        $action->execute($productDTO);
        return $next($productDTO);
    }
}
