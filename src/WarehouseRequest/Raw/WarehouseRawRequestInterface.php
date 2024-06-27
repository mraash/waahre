<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Raw;

use App\WarehouseRequest\Clean\ProductRow;

interface WarehouseRawRequestInterface
{
    /**
     * @return ProductRow[]
     */
    public function getProductList(): array;
}
