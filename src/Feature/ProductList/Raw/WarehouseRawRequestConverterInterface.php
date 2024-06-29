<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw;

use App\Feature\ProductList\Clean\WarehouseRequest;

interface WarehouseRawRequestConverterInterface
{
    public function decode(WarehouseRawRequestInterface $rawRequest): WarehouseRequest;

    public function encode(WarehouseRequest $cleanRequest): WarehouseRawRequestInterface;
}
