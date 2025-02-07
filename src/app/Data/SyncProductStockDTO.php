<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "SyncProductStockDTO",
    title: "Sync Product Stock Data Transfer Object",
    description: "Data structure for synchronizing product stock",
    properties: [
        new OA\Property(property: "product_id", description: "Unique identifier of the product.", type: "integer", example: 101),
        new OA\Property(property: "stock", description: "Updated stock quantity of the product.", type: "integer", example: 50)
    ],
    type: "object"
)]
final class SyncProductStockDTO extends Data
{
    public function __construct(
        public int $product_id,
        public int $stock,
    ) {}
}
