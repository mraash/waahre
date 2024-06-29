<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\WriteOff;

use App\Feature\ProductList\Clean\WarehouseRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductExelWriteOff
{
    private const XSL_TEMPLATE = '/var/www/html/templates/exel/write-off-template.xls';

    private const COLUMN_TYPE = 'A';
    private const COLUMN_CODE = 'B';
    private const COLUMN_QUANTITY = 'C';

    private const TYPE_DEFAULT_VALUE = 'Nomenklatūra';

    /**
     * @param WriteOffProduct[] $productList
     */
    public function __construct(
        private array $productList,
    ) {
    }

    public function getRawData(): ProductExelWriteOffSpreadsheet
    {
        $spreadsheet = IOFactory::load(self::XSL_TEMPLATE);

        $sheet = $spreadsheet->getActiveSheet();
        $currentRow = 2;

        foreach ($this->productList as $product) {
            $typeCell = self::COLUMN_TYPE . $currentRow;
            $codeCell = self::COLUMN_CODE . $currentRow;
            $quantityCell = self::COLUMN_QUANTITY . $currentRow;

            $sheet->setCellValue($typeCell, self::TYPE_DEFAULT_VALUE);
            $sheet->setCellValue($codeCell, $product->code);
            $sheet->setCellValue($quantityCell, $product->quantity);

            $currentRow++;
        }

        return new ProductExelWriteOffSpreadsheet($spreadsheet);
    }
}
