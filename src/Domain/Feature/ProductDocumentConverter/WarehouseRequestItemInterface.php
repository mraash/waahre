<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocumentConverter;

interface WarehouseRequestItemInterface
{
    public function getCode(): string;

    public function getName(): string;

    public function getTotalQuantity(): float;
}
