<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Raw\Html;

use App\WarehouseRequest\Clean\WarehouseRequest;
use App\WarehouseRequest\Raw\WarehouseRawRequestConverterInterface;
use App\WarehouseRequest\Raw\WarehouseRawRequestInterface;

class WarehouseRequestHtmlConverter implements WarehouseRawRequestConverterInterface
{
    /**
     * @param WarehouseHtmlRequest $rawRequest
     */
    public function decode(WarehouseRawRequestInterface $rawRequest): WarehouseRequest
    {
        return new WarehouseRequest($rawRequest->getProductList());
    }

    public function encode(WarehouseRequest $rawRequest): WarehouseHtmlRequest
    {
        // TODO: Write method

        throw new \Exception(':(');
    }
}
