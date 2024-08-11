<?php

declare(strict_types=1);

namespace App\Domain\Service\Seeder;

use App\Domain\Service\Creation\ProductHorizonCreation;
use App\Data\Repository\ProductHorizonRepository;
use App\Domain\Feature\ProductDocument\HorizonProducts\HorizonProducts;

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

            $horizonProductList[] = ProductHorizonCreation::create(
                $productRow->code,
                $productRow->name,
            );
        }

        $this->repository->saveList($horizonProductList);
        $this->repository->flush();
    }
}
