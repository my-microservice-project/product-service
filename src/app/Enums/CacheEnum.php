<?php

namespace App\Enums;

enum CacheEnum: string
{
    case PRODUCT = 'product:';
    case STOCK = 'stock:';

    public function getValue(): string
    {
        return $this->value;
    }

    public function getTTL(): int
    {
        return match ($this) {
            self::PRODUCT, self::STOCK => 3600,
            'default' => 0,
        };
    }
}
