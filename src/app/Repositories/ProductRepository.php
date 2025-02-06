<?php

namespace App\Repositories;

use App\Data\ProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $model)
    {}

    public function create(array $data): ProductDTO
    {
        $createdProduct = $this->model->create($data);
        return ProductDTO::from($createdProduct);
    }

    public function update(array $data): ProductDTO
    {
        $product = $this->model->find($data['id']);
        $product->update($data);
        return ProductDTO::from($product);
    }

    public function getProductById(int $productId): ProductDTO
    {
        $product = $this->model->find($productId);
        return ProductDTO::from($product);
    }

}
