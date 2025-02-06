<?php

namespace App\Pipelines;

use App\Pipelines\Stages\{UpdateOrCreateProduct,SyncStock,UpdateCache};

class ProductUpdateOrCreatePipeline
{
    public static function stages(): array
    {
        return [
            UpdateOrCreateProduct::class,
            SyncStock::class,
            UpdateCache::class,
        ];
    }
}
