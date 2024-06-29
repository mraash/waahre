<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Converter;

use App\Feature\ProductList\Raw\WarehouseRequest\ProductHtmlRequest;
use App\Feature\ProductList\Raw\WriteOff\ProductExelWriteOff;
use App\Feature\ProductList\Raw\WriteOff\ProductExelWriteOffSpreadsheet;
use App\Feature\ProductList\Raw\WriteOff\WriteOffProduct;

class WarehouseRequestToWriteOffConverter
{
    public function convert(ProductHtmlRequest $productHtmlList): ProductExelWriteOff
    {
        $htmlProducts = $productHtmlList->getProductList();

        $exelProducts = [];

        foreach ($htmlProducts as $htmlProduct) {
            $exelProducts[] = new WriteOffProduct(
                $htmlProduct->code,
                $htmlProduct->quantityTotal,
            );
        }

        return new ProductExelWriteOff($exelProducts);
    }

    public function convertFully(string $warehouseRequestHtml): ProductExelWriteOffSpreadsheet
    {
        $productHtmlRequest = new ProductHtmlRequest($warehouseRequestHtml);

        return $this->convert($productHtmlRequest)->getRawData();
    }
}
