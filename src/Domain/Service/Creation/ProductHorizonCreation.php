<?php

declare(strict_types=1);

namespace App\Domain\Service\Creation;

use App\Data\Entity\ProductHorizon;

class ProductHorizonCreation
{
    public static function create(string $code, string $name): ProductHorizon
    {
        return (new PRoductHorizon())
            ->setCode($code)
            ->setName($name)
        ;
    }
}
