<?php

declare(strict_types=1);

namespace App\Data\Creation;

use App\Data\Entity\ProductFRestaurant;

class ProductFRestaurantCreation
{
    public static function create(string $code, string $name): ProductFRestaurant
    {
        return (new ProductFRestaurant())
            ->setCode($code)
            ->setName($name)
        ;
    }
}
