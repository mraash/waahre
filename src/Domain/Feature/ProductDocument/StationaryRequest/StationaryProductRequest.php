<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\StationaryProductRequest;

use App\Domain\Feature\ProductDocumentConverter\WarehouseRequestInterface;
use DOMDocument;
use DOMElement;
use DOMNodeList;

class StationaryProductRequest implements WarehouseRequestInterface
{
    private const IGNORE_LIST = ['000000'];

    /**
     * @param StationaryProductRequestItem[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public static function fromHtmlString(string $html): self
    {
        // TODO: refactor shitcode here

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        /** @var DOMElement */
        $table = $dom->getElementsByTagName('table')->item(1);

        $rows = $table->getElementsByTagName('tr');

        $items = [];

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

            $items[] = new StationaryProductRequestItem(
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

        return new self($items);
    }

    public static function fromFile(string $filename): self
    {
        $content = file_get_contents($filename);

        return self::fromHtmlString($content);
    }

    /**
     * @return StationaryProductRequestItem[]
     */
    public function getItems(): array
    {
        return $this->items;
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
