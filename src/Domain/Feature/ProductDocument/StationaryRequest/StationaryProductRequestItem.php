<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\StationaryProductRequest;

use App\Domain\Feature\ProductDocumentConverter\WarehouseRequestItemInterface;

class StationaryProductRequestItem implements WarehouseRequestItemInterface
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTotalQuantity(): float
    {
        return $this->quantityTotal;
    }
}
