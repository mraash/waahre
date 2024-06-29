<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw\Html;

use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestInterface;
use DOMDocument;
use DOMElement;
use App\Feature\WarehouseRequest\Clean\ProductRow;

class WarehouseHtmlRequest implements WarehouseRawRequestInterface
{
    /** @var ProductRow[] */
    private array $productList = [];

    public function __construct(string $html)
    {
        // TODO: refactor shitcode here

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        /** @var DOMElement */
        $table = $dom->getElementsByTagName('table')->item(1);

        $rows = $table->getElementsByTagName('tr');

        // $hasTable = preg_match("/\<table\>/", $html, $matches);

        // if (!$hasTable) {
        //     throw new \Exception(':(');
        // }

        // $htmlTable = $matches[0];

        // $dom = new DOMDocument();
        // $dom->loadHTML($htmlTable);

        // $rows = $dom->getElementsByTagName('tr');

        foreach ($rows as $cellNode) {
            /** @var DOMElement $cellNode */

            $isHeaderRow = $cellNode->getElementsByTagName('th')->count() > 0;

            if ($isHeaderRow) {
                continue;
            }

            $cells = $cellNode->getElementsByTagName('td');

            $code = trim($cells->item(0)->textContent);
            $name = trim($cells->item(1)->textContent);
            $quantity = (float) str_replace(',', '.', trim($cells->item(8)->textContent));

            $this->productList[] = ProductRow::fromPrimitives($code, $name, $quantity);
        }
    }

    /**
     * @return ProductRow[]
     */
    public function getProductList(): array
    {
        return $this->productList;
    }
}
