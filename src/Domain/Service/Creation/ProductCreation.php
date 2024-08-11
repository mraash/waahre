<?php

declare(strict_types=1);

namespace App\Domain\Service\Creation;

use App\Data\Entity\Product;

class ProductCreation
{
    public static function create(string $name, string $slug = null, string $orderName = null): Product
    {
        if ($slug === null) {
            $slug = self::makeSlug($name);
        }

        if ($orderName === null) {
            $orderName = $name;
        }

        return (new Product())
            ->setName($name)
            ->setSlug($slug)
            ->setOrderName($orderName)
        ;
    }

    private static function makeSlug(string $string): string
    {
        // TODO: Move this method somewhere

        $table = [
            'ā' => 'a',
            'ē' => 'e',
            'ī' => 'i',
            'ū' => 'u',
            'č' => 'c',
            'ģ' => 'g',
            'ķ' => 'k',
            'ļ' => 'l',
            'ņ' => 'n',
            'š' => 's',
            'ž' => 'z',
        ];

        $slug = $string;
        $slug = mb_strtolower($slug);
        $slug = trim($slug);

        foreach ($table as $invalid => $valid) {
            $slug = str_replace($invalid, $valid, $slug);
        }

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}
