<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Raw;

use App\WarehouseRequest\Clean\WarehouseRequest;

interface WarehouseRawRequestConverterInterface
{
    public function decode(WarehouseRawRequestInterface $rawRequest): WarehouseRequest;

    public function encode(WarehouseRequest $cleanRequest): WarehouseRawRequestInterface;
}
