<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\BuffetProductRequest;

use App\Domain\Feature\ProductDocumentConverter\WarehouseRequestInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuffetProductRequest implements WarehouseRequestInterface
{
    /**
     * @param BuffetProductRequestItem[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public static function fromFile(string $filename): self
    {
        $spreadsheet = IOFactory::load($filename);
        $sheet = $spreadsheet->getActiveSheet();

        $headerCells = self::findHeaderInSheet($sheet);

        $codeColumn = $headerCells[0];
        $nameColumn = chr(ord($headerCells[0]) + 1);
        $unitColumn = chr(ord($headerCells[0]) + 2);
        $notesColumn = chr(ord($headerCells[0]) + 3);
        $quantityColumn = chr(ord($headerCells[0]) + 4);

        $currentRow = $headerCells[1] + 1;

        $items = [];

        while (true) {
            $codeValue = $sheet->getCell($codeColumn . $currentRow)->getValueString();
            $nameValue = $sheet->getCell($nameColumn . $currentRow)->getValueString();
            $unitValue = $sheet->getCell($unitColumn . $currentRow)->getValueString();
            $notesValue = $sheet->getCell($notesColumn . $currentRow)->getValueString();
            $quantityValue = $sheet->getCell($quantityColumn . $currentRow)->getValueString();

            if (empty($codeValue) || empty($nameValue) || empty($quantityValue)) {
                break;
            }

            $items[] = new BuffetProductRequestItem(
                $codeValue,
                $nameValue,
                $unitValue,
                $notesValue,
                self::stringToFloat($quantityValue),
            );

            $currentRow++;
        }

        return new self($items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    private static function findHeaderInSheet(Worksheet $sheet): array
    {
        $columnsToCheck = range('a', 'c');
        $rowsToCheck = range(1, 20);

        $headersRow = null;
        $firstHeaderColumn = null;
        $firstHeaderValue = 'Kods';

        foreach ($rowsToCheck as $row) {
            foreach ($columnsToCheck as $column) {
                $cellValue = $sheet->getCell($column . $row)->getValueString();

                if ($cellValue === $firstHeaderValue) {
                    $headersRow = $row;
                    $firstHeaderColumn = $column;

                    break 2;
                }
            }
        }

        if ($headersRow === null || $firstHeaderColumn === null) {
            // TODO: Handle error correctly
            throw new \RuntimeException('Invalid buffet file');
        }

        return [$firstHeaderColumn, $headersRow];
    }

    private static function stringToFloat(string $value): float
    {
        return (float) str_replace(',', '.', $value);
    }
}
