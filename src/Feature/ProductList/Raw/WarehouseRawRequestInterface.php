<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw;

use App\Feature\ProductList\Clean\ProductRow;

interface WarehouseRawRequestInterface
{
    /**
     * @return ProductRow[]
     */
    public function getProductList(): array;
}
