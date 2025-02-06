<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Repositories\Contracts\ProductRepositoryInterface;

class CreateProductAction
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(ProductDTO $dto): ProductDTO
    {
        $product = $this->productRepository->create($dto->exclude('stock')->toArray());

        return ProductDTO::from($product->additional(['stock' => $dto->stock]));
    }

}
