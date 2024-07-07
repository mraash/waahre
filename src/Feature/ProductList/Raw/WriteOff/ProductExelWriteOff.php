<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\WriteOff;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\TextElement;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProductExelWriteOff
{
    private const COLUMN_CODE = 'A';
    private const COLUMN_QUANTITY = 'B';

    /**
     * @param WriteOffProduct[] $productList
     */
    public function __construct(
        private array $productList,
    ) {
    }

    public function getRawData(): ProductExelWriteOffSpreadsheet
    {
        $spreadsheet = $this->prepareSpreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $currentRow = 2;

        foreach ($this->productList as $product) {
            $codeCell = self::COLUMN_CODE . $currentRow;
            $quantityCell = self::COLUMN_QUANTITY . $currentRow;

            $sheet->setCellValue($codeCell, $product->horizonCode);
            $sheet->setCellValue($quantityCell, $product->quantity);

            $currentRow++;
        }

        return new ProductExelWriteOffSpreadsheet($spreadsheet);
    }

    private function prepareSpreadsheet(): Spreadsheet
    {
        $spreadsheet = IOFactory::load('/var/www/html/templates/exel/products/write-off.xls');

        return $spreadsheet;
    }
}
