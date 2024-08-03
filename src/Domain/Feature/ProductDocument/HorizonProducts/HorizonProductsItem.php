<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\HorizonProducts;

class HorizonProductsItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
    ) {
    }
}
