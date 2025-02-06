<?php

namespace App\Repositories\Contracts;

use App\Data\ProductDTO;

interface ProductRepositoryInterface
{
    public function create(array $data): ProductDTO;

    public function update(array $data): ProductDTO;

    public function getProductById(int $productId): ProductDTO;
}
