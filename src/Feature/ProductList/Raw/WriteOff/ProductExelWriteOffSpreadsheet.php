<?php

declare(strict_types=1);

namespace App\Feature\ProductList\Raw\WriteOff;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductExelWriteOffSpreadsheet
{
    public function __construct(
        private readonly Spreadsheet $spreadsheet,
    ) {
    }

    public function save(string $filename): void
    {
        $writer = new Xlsx($this->spreadsheet);

        $writer->save($filename);
    }
}
