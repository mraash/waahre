<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductListDocuments\Raw\WarehouseRequest;

class WarehouseRequestProduct
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $unit,
        public readonly string $notes,
        public readonly float $quantityBreakfast,
        public readonly float $quantityLunch,
        public readonly float $quantityAfternoon,
        public readonly float $quantityDinner,
        public readonly float $quantityTotal,
    ) {
    }
}
