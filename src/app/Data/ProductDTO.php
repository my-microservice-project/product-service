<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

#[OA\Schema(
    schema: "ProductDTO",
    title: "Product Data Transfer Object",
    description: "Product information",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 28, nullable: true, description: "Unique identifier of the product, optional."),
        new OA\Property(property: "name", type: "string", example: "iPhone 15 Pro", nullable: true, description: "Product name. If not provided, 'description' or a default value is used."),
        new OA\Property(property: "description", type: "string", example: "Apple's latest model", nullable: true, description: "Product description. If 'name' is missing, this value is used."),
        new OA\Property(property: "category", type: "integer", example: 1, description: "Category ID of the product."),
        new OA\Property(property: "price", type: "number", format: "float", example: 1299.99, description: "Price of the product."),
        new OA\Property(property: "stock", type: "integer", example: 50, description: "Stock quantity of the product.")
    ],
    type: "object"
)]
final class ProductDTO extends Data
{
    public function __construct(
        public int $category,
        public float $price,
        public ?int $stock = 0,
        public ?string $name = null,
        public ?string $description = null,
        public ?int $id = null
    ) {}

    public static function collection(array $items): DataCollection
    {
        return new DataCollection(self::class, array_map(
            fn($item) => new self(
                category: $item['category'],
                price: $item['price'],
                stock: $item['stock'] ?? 0,
                name: $item['name'] ?? null,
                description: $item['description'] ?? null,
                id: $item['id'] ?? null,
            ),
            $items
        ));
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }
}
