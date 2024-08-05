<?php

declare(strict_types=1);

namespace App\Data\PlainEntity;

use App\Data\Entity\Product;
use App\Data\Entity\ProductFRestaurant;
use App\Data\Entity\ProductHorizon;

class ProductSet
{
    public function __construct(
        private Product $product,
        private ProductHorizon $horizonProduct,
        private ProductFRestaurant $frestaurantProduct,
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getHorizonProduct(): ProductHorizon
    {
        return $this->horizonProduct;
    }

    public function getFrestaurantProduct(): ProductFRestaurant
    {
        return $this->frestaurantProduct;
    }
}
