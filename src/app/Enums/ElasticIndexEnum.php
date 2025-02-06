<?php

namespace App\Enums;

enum ElasticIndexEnum: string
{
    case PRODUCTS = 'products';

    public function getValue(): string
    {
        return $this->value;
    }
}
