<?php

declare(strict_types=1);

namespace App\WarehouseRequest\Clean;

use App\Entity\Product;

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
