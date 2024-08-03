<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocumentConverter;

interface WarehouseRequestInterface
{
    /**
     * @return WarehouseRequestItemInterface[]
     */
    public function getItems(): array;
}
