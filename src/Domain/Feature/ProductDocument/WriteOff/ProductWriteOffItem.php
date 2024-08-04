<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\WriteOff;

class ProductWriteOffItem
{
    public function __construct(
        public readonly string $horizonCode,
        public readonly float $quantity,
    ) {
    }
}
