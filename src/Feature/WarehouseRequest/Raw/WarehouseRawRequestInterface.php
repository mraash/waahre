<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw;

use App\Feature\WarehouseRequest\Clean\ProductRow;

interface WarehouseRawRequestInterface
{
    /**
     * @return ProductRow[]
     */
    public function getProductList(): array;
}
