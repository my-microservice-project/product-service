<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class ProductElasticDTO extends Data
{
    public function __construct(
        public readonly string $index,
        public readonly string $id,
        public readonly ProductDTO $body
    )
    {}
}
