<?php

namespace App\Data;

use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * @OA\Schema(
 *     schema="ProductDTO",
 *     type="object",
 *     title="Product Data Transfer Object",
 *     description="Product information",
 *     @OA\Property(property="id", type="integer", example=28, nullable=true, description="Ürünün benzersiz kimliği, opsiyonel"),
 *     @OA\Property(property="name", type="string", example="iPhone 15 Pro", nullable=true, description="Ürün adı. Eğer yoksa 'description' veya varsayılan değer kullanılır."),
 *     @OA\Property(property="description", type="string", example="Apple'ın en son modeli", nullable=true, description="Ürünün açıklaması. Eğer 'name' yoksa bu değer kullanılabilir."),
 *     @OA\Property(property="category", type="integer", example=1, description="Ürünün ait olduğu kategori ID'si"),
 *     @OA\Property(property="price", type="number", format="float", example=1299.99, description="Ürünün fiyatı"),
 *     @OA\Property(property="stock", type="integer", example=50, description="Ürünün stok adedi")
 * )
 */
final class ProductDTO extends Data
{
    public function __construct(
        public int $category,
        public float $price,
        public ?int $stock=0,
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
