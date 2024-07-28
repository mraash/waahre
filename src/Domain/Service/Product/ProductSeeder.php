<?php

declare(strict_types=1);

namespace App\Domain\Service\Product;

use App\Data\Repository\ProductHorizonRepository;
use App\Data\Repository\ProductRepository;

class ProductSeeder
{
    public function __construct(
        private readonly ProductRepository $repository,
        private readonly ProductHorizonRepository $horizonProductRepository,
    ) {
    }

    public function fillDbTableByCopyingHroizonProducts(): void
    {
        $horizonProducts = $this->horizonProductRepository->findAll();
        $products = [];

        foreach ($horizonProducts as $horizonProduct) {
            $product = $this->repository->createEntity($horizonProduct->getName());
            $product->setHorizonTwin($horizonProduct);

            $products[] = $product;
        }

        $this->repository->saveList($products);
        $this->repository->flush();
    }
}
