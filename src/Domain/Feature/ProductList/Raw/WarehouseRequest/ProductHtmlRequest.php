<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductList\Raw\WarehouseRequest;

use DOMDocument;
use DOMElement;
use DOMNodeList;

class ProductHtmlRequest
{
    /** @var WarehouseRequestProduct[] */
    private array $productList = [];

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

            $this->productList[] = new WarehouseRequestProduct(
                self::cellToString($cells, 0),
                self::cellToString($cells, 1),
                self::cellToString($cells, 2),
                self::cellToString($cells, 3),
                self::cellToFloat($cells, 4),
                self::cellToFloat($cells, 5),
                self::cellToFloat($cells, 6),
                self::cellToFloat($cells, 7),
                self::cellToFloat($cells, 8),
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
        return trim($nodeList->item($index)->textContent);
    }

    private static function cellToFloat(DOMNodeList $nodeList, int $index): float
    {
        return (float) str_replace(',', '.', trim($nodeList->item($index)->textContent));
    }
}
