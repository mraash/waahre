<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductListDocuments\Raw\WarehouseRequest;

use DOMDocument;
use DOMElement;
use DOMNodeList;

class ProductHtmlRequest
{
    /** @var WarehouseRequestProduct[] */
    private array $productList = [];

    private const IGNORE_LIST = ['000000'];

    public function __construct(string $html)
    {
        // TODO: refactor shitcode here

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        /** @var DOMElement */
        $table = $dom->getElementsByTagName('table')->item(1);

        $rows = $table->getElementsByTagName('tr');

        foreach ($rows as $rowNode) {
            /** @var DOMElement $rowNode */

            $isHeaderRow = $rowNode->getElementsByTagName('th')->count() > 0;

            if ($isHeaderRow) {
                continue;
            }

            $cells = $rowNode->getElementsByTagName('td');

            $code              = self::cellToString($cells, 0);
            $name              = self::cellToString($cells, 1);
            $unit              = self::cellToString($cells, 2);
            $notes             = self::cellToString($cells, 3);
            $quantityBreakfast = self::cellToFloat($cells, 4);
            $quantityLunch     = self::cellToFloat($cells, 5);
            $quantityAfternoon = self::cellToFloat($cells, 6);
            $quantityDinner    = self::cellToFloat($cells, 7);
            $quantityTotal     = self::cellToFloat($cells, 8);

            // TODO: Move this logic somewhere
            if (in_array($code, self::IGNORE_LIST)) {
                continue;
            }

            $this->productList[] = new WarehouseRequestProduct(
                $code,
                $name,
                $unit,
                $notes,
                $quantityBreakfast,
                $quantityLunch,
                $quantityAfternoon,
                $quantityDinner,
                $quantityTotal,
            );
        }
    }

    /**
     * @return WarehouseRequestProduct[]
     */
    public function getProductList(): array
    {
        return $this->productList;
    }

    private static function cellToString(DOMNodeList $nodeList, int $index): string
    {
        return $nodeList->item($index)->textContent;
    }

    private static function cellToFloat(DOMNodeList $nodeList, int $index): float
    {
        return (float) str_replace(',', '.', $nodeList->item($index)->textContent);
    }
}
