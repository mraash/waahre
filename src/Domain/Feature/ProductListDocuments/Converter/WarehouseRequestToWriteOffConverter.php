<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductListDocuments\Converter;

use App\Data\Entity\Product;
use App\Data\Entity\ProductFRestaurant;
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
            $product = current(array_filter(
                $products,
                function (Product $product) use ($htmlProduct) {
                    $frestaurantProdcuts = $product->getFRestaurantTwins()->toArray();
                    $frestaurantCodes = array_map(
                        fn (ProductFRestaurant $productFRestaurant) => $productFRestaurant->getCode(),
                        $frestaurantProdcuts,
                    );

                    // TODO: Rethink this logic
                    return in_array($htmlProduct->code, $frestaurantCodes);
                }
            ));

            // dump($product->getHorizonTwin()->getName());

            $exelProducts[] = new WriteOffProduct(
                $product->getHorizonTwin()->getCode(),
                $htmlProduct->quantityTotal,
            );
        }

        // dd(1);

        return new ProductExelWriteOff($exelProducts);
    }

    public function convertFully(string $warehouseRequestHtml): ProductExelWriteOffSpreadsheet
    {
        $productHtmlRequest = new ProductHtmlRequest($warehouseRequestHtml);

        return $this->convert($productHtmlRequest)->getRawData();
    }
}
