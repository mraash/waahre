<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw\Html;

use App\Feature\WarehouseRequest\Clean\WarehouseRequest;
use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestConverterInterface;
use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestInterface;

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
