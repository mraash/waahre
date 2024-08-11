<?php

declare(strict_types=1);

namespace App\Domain\Service\Seeder;

use App\Domain\Service\Creation\ProductCreation;
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
            $product = ProductCreation::create($horizonProduct->getName());
            $product->addHorizonLink($horizonProduct);

            $products[] = $product;
        }

        $this->repository->saveList($products);
        $this->repository->flush();
    }
}
