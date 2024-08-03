<?php

declare(strict_types=1);

namespace App\Domain\Feature\ProductDocument\WriteOff;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ProductExelWriteOffSpreadsheet
{
    public function __construct(
        private readonly Spreadsheet $spreadsheet,
    ) {
    }

    public function save(string $filename): void
    {
        $writer = new Xls($this->spreadsheet);

        $writer->save($filename);
    }
}
