<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\BuffetRequest;

use App\Domain\Feature\ProductDocumentConverter\WarehouseRequestItemInterface;

class BuffetRequestItem implements WarehouseRequestItemInterface
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly string $unit,
        private readonly string $notes,
        private readonly float $quantity,
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
        return $this->quantity;
    }
}
