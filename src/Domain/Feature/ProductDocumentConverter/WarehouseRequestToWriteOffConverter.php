<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocumentConverter;

use App\Data\Entity\Product;
use App\Data\Entity\ProductFRestaurant;
use App\Data\Repository\ProductRepository;
use App\Domain\Feature\ProductDocument\WriteOff\ProductExelWriteOff;
use App\Domain\Feature\ProductDocument\WriteOff\WriteOffProduct;

class WarehouseRequestToWriteOffConverter
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function convert(WarehouseRequestInterface $productHtmlList): ProductExelWriteOff
    {
        $htmlProducts = $productHtmlList->getItems();

        $fRestaurantCodes = [];

        foreach ($htmlProducts as $htmlProduct) {
            $fRestaurantCodes[] = $htmlProduct->getCode();
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
                    return in_array($htmlProduct->getCode(), $frestaurantCodes);
                }
            ));

            // dump($product->getHorizonTwin()->getName());

            $exelProducts[] = new WriteOffProduct(
                $product->getHorizonTwin()->getCode(),
                $htmlProduct->getTotalQuantity(),
            );
        }

        // dd(1);

        return new ProductExelWriteOff($exelProducts);
    }
}
