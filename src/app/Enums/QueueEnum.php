<?php

namespace App\Enums;

enum QueueEnum: string
{
    case PRODUCT_PROCESS = 'Product_Process';

    case SYNC_STOCK = 'Sync_Stock';

    case PRODUCT_ELASTIC_UPDATE = 'Product_Elastic_Update';

    public function getValue(): string
    {
        return $this->value;
    }
}
