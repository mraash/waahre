<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw\Exel;

use App\Feature\WarehouseRequest\Clean\ProductRow;
use App\Feature\WarehouseRequest\Clean\WarehouseRequest;
use App\Feature\WarehouseRequest\Raw\WarehouseRawRequestInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class WarehouseExelRequest implements WarehouseRawRequestInterface
{
    private const XSL_TEMPLATE = '/var/www/html/templates/exel/write-off-template.xls';

    private const TYPE_COLUMN = 'A';
    private const CODE_COLUMN = 'B';
    private const QUANTITY_COLUMN = 'C';

    private const TYPE_DEFAULT_VALUE = 'Nomenklatūra';

    public function __construct(
        private WarehouseRequest $warehouseRequest,
    ) {
    }

    /**
     * @return ProductRow[]
     */
    public function getProductList(): array
    {
        throw new \Exception('');
    }

    public function getRawData(): WarehouseRequestSheet
    {
        $productList = $this->warehouseRequest->getProductList();

        $spreadsheet = IOFactory::load(self::XSL_TEMPLATE);

        $sheet = $spreadsheet->getActiveSheet();
        $currentRow = 2;

        foreach ($productList as $product) {
            $typeCell = self::TYPE_COLUMN . $currentRow;
            $codeCell = self::CODE_COLUMN . $currentRow;
            $quantityCell = self::QUANTITY_COLUMN . $currentRow;

            $sheet->setCellValue($typeCell, self::TYPE_DEFAULT_VALUE);
            $sheet->setCellValue($codeCell, $product->product->code);
            $sheet->setCellValue($quantityCell, $product->quantityTotal);

            $currentRow++;
        }

        return new WarehouseRequestSheet($spreadsheet);
    }
}
