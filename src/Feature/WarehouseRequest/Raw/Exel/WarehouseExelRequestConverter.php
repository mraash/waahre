<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw\Exel;

use App\Feature\WarehouseRequest\Clean\WarehouseRequest;
use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestConverterInterface;
use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestInterface;

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
