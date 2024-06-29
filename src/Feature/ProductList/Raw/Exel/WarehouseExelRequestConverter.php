<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\Exel;

use App\Feature\ProductList\Clean\WarehouseRequest;
use App\Feature\ProductList\Raw\WarehouseRawRequestConverterInterface;
use App\Feature\ProductList\Raw\WarehouseRawRequestInterface;

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
