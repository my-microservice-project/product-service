<?php

namespace App\Repositories\Contracts;

use App\Data\ProductSearchDTO;
use Illuminate\Support\Collection;

interface ProductSearchRepositoryInterface
{
    public function search(ProductSearchDTO $dto): Collection;
}
