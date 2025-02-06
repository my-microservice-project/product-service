<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Repositories\Contracts\ProductRepositoryInterface;

class UpdateProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(ProductDTO $dto): ProductDTO
    {
        $product = $this->productRepository->update($dto->exclude('stock')->toArray());

        return ProductDTO::from($product->additional(['stock' => $dto->stock]));
    }
}
