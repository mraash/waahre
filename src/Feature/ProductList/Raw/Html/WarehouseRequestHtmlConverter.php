<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\Html;

use App\Feature\ProductList\Clean\WarehouseRequest;
use App\Feature\ProductList\Raw\WarehouseRawRequestConverterInterface;
use App\Feature\ProductList\Raw\WarehouseRawRequestInterface;

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
