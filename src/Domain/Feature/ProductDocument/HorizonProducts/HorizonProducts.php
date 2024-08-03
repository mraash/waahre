<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\HorizonProducts;

use PhpOffice\PhpSpreadsheet\IOFactory;

class HorizonProducts
{
    /**
     * @param HorizonProductsItem[] $items
     */
    public function __construct(
        private array $items,
    ) {
    }

    public static function fromFile(string $filename): self
    {
        $spreadsheet = IOFactory::load($filename);
        $sheet = $spreadsheet->getActiveSheet();

        $items = [];
        $currentRow = 2;

        while (true) {
            $code = $sheet->getCell("B$currentRow")->getValueString();
            $name = $sheet->getCell("D$currentRow")->getValueString();

            if (empty($code) || empty($name)) {
                break;
            }

            $items[] = new HorizonProductsItem($code, $name);
            $currentRow++;
        }

        return new self($items);
    }

    /**
     * @return HorizonProductsItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
