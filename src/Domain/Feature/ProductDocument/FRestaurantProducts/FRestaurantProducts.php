<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\FRestaurantProducts;

use DOMDocument;
use DOMElement;

class FRestaurantProducts
{
    /** @var FRestaurantProductsItem[] */
    private array $productList = [];

    /**
     * @param FRestaurantProductsItem[] $productList
     */
    public function __construct($productList)
    {
        $this->productList = $productList;
    }

    public static function fromFile(string $filename): self
    {
        $html = file_get_contents($filename);

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        /** @var DOMElement */
        $table = $dom->getElementsByTagName('table')->item(0);

        $rows = $table->getElementsByTagName('tr');

        $productList = [];

        foreach ($rows as $rowNode) {
            /** @var DOMElement $rowNode */

            $isHeaderRow = $rowNode->getElementsByTagName('th')->count() > 0;

            if ($isHeaderRow) {
                continue;
            }

            $cells = $rowNode->getElementsByTagName('td');

            $code = (string) $cells->item(1)->textContent;
            $name = (string) $cells->item(2)->textContent;

            if (str_starts_with($name, 'DZĒST ')) {
                continue;
            }

            $productList[] = new FRestaurantProductsItem($code, $name);
        }

        return new self($productList);
    }

    /**
     * @return FRestaurantProductsItem[]
     */
    public function getItems(): array
    {
        return $this->productList;
    }
}
