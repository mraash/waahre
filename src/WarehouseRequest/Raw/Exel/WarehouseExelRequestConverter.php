<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Raw\Exel;

use App\WarehouseRequest\Clean\WarehouseRequest;
use App\WarehouseRequest\Raw\WarehouseRawRequestConverterInterface;
use App\WarehouseRequest\Raw\WarehouseRawRequestInterface;

class WarehouseExelRequestConverter implements WarehouseRawRequestConverterInterface
{
    public function decode(WarehouseRawRequestInterface $rawRequest): WarehouseRequest
    {
        throw new \Exception('');
    }

    public function encode(WarehouseRequest $cleanRequest): WarehouseExelRequest
    {
        return new WarehouseExelRequest($cleanRequest);
    }
}
