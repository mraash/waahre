<?php

declare(strict_types=1);

namespace App\Domain\Service\ProductHorizon;

use App\Data\Repository\ProductHorizonRepository;
use App\Domain\Feature\ProductListDocuments\Raw\HorizonProducts\HorizonProducts;

class ProductHorizonSeeder
{
    public function __construct(
        private readonly ProductHorizonRepository $repository,
    ) {
    }

    public function fillDbTableFromProductListFile(string $filename): void
    {
        $ignoreList = [
            '04-017',
            '10-003',
            '04-007_',
        ];

        $horizonProductsData = HorizonProducts::fromFile($filename);
        $horizonProductList = [];

        foreach ($horizonProductsData->getItems() as $productRow) {
            if (in_array($productRow->code, $ignoreList)) {
                continue;
            }

            $horizonProductList[] = $this->repository->createEntity(
                $productRow->code,
                $productRow->name,
            );
        }

        $this->repository->saveList($horizonProductList);
        $this->repository->flush();
    }
}
