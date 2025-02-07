<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "ProductSearchDTO",
    title: "Product Search Data Transfer Object",
    description: "Data structure for searching products",
    properties: [
        new OA\Property(property: "query", description: "Keyword to search for in product names or descriptions.", type: "string", example: "iPhone"),
        new OA\Property(property: "category", description: "Filter by category ID.", type: "integer", example: 1, nullable: true),
        new OA\Property(property: "min_price", description: "Minimum price filter.", type: "number", format: "float", example: 1000.00, nullable: true),
        new OA\Property(property: "max_price", description: "Maximum price filter.", type: "number", format: "float", example: 5000.00, nullable: true),
        new OA\Property(property: "min_stock", description: "Minimum stock quantity filter.", type: "integer", example: 10, nullable: true),
        new OA\Property(property: "max_stock", description: "Maximum stock quantity filter.", type: "integer", example: 100, nullable: true)
    ],
    type: "object"
)]
final class ProductSearchDTO extends Data
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
