<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Item::with(['category', 'unit', 'department'])->get();
    }

    public function map($item): array
    {
        return [
            $item->name_bn,
            $item->name_en,
            $item->category ? $item->category->name_en : '',
            $item->department ? $item->department->name : '',
            $item->unit ? $item->unit->name_en : '',
            $item->amount,
            $item->service_type,
            $item->description,
        ];
    }

    public function headings(): array
    {
        return [
            'নাম (বাংলা)',
            'নাম (ইংরেজি)',
            'ক্যাটাগরি',
            'ডিপার্টমেন্ট',
            'ইউনিট',
            'পরিমাণ',
            'পরিষেবার ধরণ',
            'বিবরণ',
        ];
    }
}
