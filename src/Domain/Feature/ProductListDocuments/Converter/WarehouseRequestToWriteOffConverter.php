<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductListDocuments\Converter;

use App\Data\Entity\Product;
use App\Data\Repository\ProductRepository;
use App\Domain\Feature\ProductListDocuments\Raw\WarehouseRequest\ProductHtmlRequest;
use App\Domain\Feature\ProductListDocuments\Raw\WriteOff\ProductExelWriteOff;
use App\Domain\Feature\ProductListDocuments\Raw\WriteOff\ProductExelWriteOffSpreadsheet;
use App\Domain\Feature\ProductListDocuments\Raw\WriteOff\WriteOffProduct;

class WarehouseRequestToWriteOffConverter
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function convert(ProductHtmlRequest $productHtmlList): ProductExelWriteOff
    {
        $htmlProducts = $productHtmlList->getProductList();

        $fRestaurantCodes = [];

        foreach ($htmlProducts as $htmlProduct) {
            $fRestaurantCodes[] = $htmlProduct->code;
        }

        $products = $this->productRepository->findListByFRestaurantCodes($fRestaurantCodes);

        $exelProducts = [];

        foreach ($htmlProducts as $htmlProduct) {
            $product = current(
                array_filter(
                    $products,
                    fn (Product $product) => $product->getFRestaurantTwins()[0]->getCode() === $htmlProduct->code
                )
            );

            $exelProducts[] = new WriteOffProduct(
                $product->getHorizonTwin()->getCode(),
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
