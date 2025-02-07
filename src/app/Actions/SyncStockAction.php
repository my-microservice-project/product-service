<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Data\SyncProductStockDTO;
use App\Enums\QueueEnum;
use App\Jobs\SyncStockJob;

class SyncStockAction
{
    public function execute(ProductDTO $productDTO): void
    {
        SyncStockJob::dispatch(
            (new SyncProductStockDTO(
                $productDTO->id,
                $productDTO->stock
            ))->toArray()
        )->onQueue(QueueEnum::SYNC_STOCK->getValue());
    }

}
