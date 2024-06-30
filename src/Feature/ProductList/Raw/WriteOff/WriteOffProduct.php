<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\WriteOff;

class WriteOffProduct
{
    public function __construct(
        public readonly string $horizonCode,
        public readonly float $quantity,
    ) {
    }
}
