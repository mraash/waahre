<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Clean;

use App\Data\Entity\Product;

class ProductRow
{
    public function __construct(
        public readonly Product $product,
        public readonly float $quantityTotal,
    ) {
    }

    public static function fromPrimitives(string $code, string $name, float $quantityTotal): ProductRow
    {
        return new self(new Product($code, $name), $quantityTotal);
    }
}
