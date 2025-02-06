<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ProductSearchDTO extends Data
{
    public function __construct(
        public string $query,
        public ?int $category = null,
        public ?float $min_price = null,
        public ?float $max_price = null,
        public ?int $min_stock = null,
        public ?int $max_stock = null
    ) {}
}
