<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ExcelDataImport implements ToCollection, WithHeadingRow
{
    public $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows->toArray();
    }
}

