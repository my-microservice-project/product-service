<?php

namespace App\Actions;

use App\Data\ProductDTO;
use App\Data\SyncProductStockDTO;
use App\Enums\QueueEnum;
use App\Jobs\SyncStockJob;
use Illuminate\Support\Facades\Log;

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

        Log::info('Stock sync job dispatched', ['product_id' => $productDTO->id]);
    }

}
