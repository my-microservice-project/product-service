<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "ProductElasticDTO",
    title: "Product Elastic Data Transfer Object",
    description: "Data structure for indexing a product in Elasticsearch",
    properties: [
        new OA\Property(property: "index", description: "Elasticsearch index name.", type: "string", example: "products"),
        new OA\Property(property: "id", description: "Unique identifier for the product document in Elasticsearch.", type: "string", example: "abc123"),
        new OA\Property(property: "body", ref: "#/components/schemas/ProductDTO", description: "Product data body to be indexed in Elasticsearch.")
    ],
    type: "object"
)]
final class ProductElasticDTO extends Data
{
    public function __construct(
        public readonly string $index,
        public readonly string $id,
        public readonly ProductDTO $body
    ) {}
}
