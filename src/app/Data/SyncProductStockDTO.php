<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SyncProductStockDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $stock,
    )
    {}
}
