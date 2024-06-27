<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Clean;

class WarehouseRequest
{
    /**
     * @param ProductRow[] $products
     */
    public function __construct(
        private array $products
    ) {
    }

    /**
     * @return ProductRow[]
     */
    public function getProductList(): array
    {
        return $this->products;
    }
}
