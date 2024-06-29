<?php

declare(strict_types=1);

namespace App\Feature\WarehouseRequest\Raw\Exel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WarehouseRequestSheet
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
