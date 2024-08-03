<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\FRestaurantProducts;

class FRestaurantProductsItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
    ) {
    }
}
