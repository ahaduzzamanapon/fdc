<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemUnit;
use App\Models\ItemDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;

class ItemsImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        

        $nameBn = $row[0] ?? null;
        $nameEn = $row[1] ?? null;
        $categoryName = $row[2] ?? null;
        $departmentName = $row[3] ?? null;
        $unitName = $row[4] ?? null;
        $amount = $row[5] ?? 0;
        $serviceType = $row[6] ?? 'Goods';
        $description = $row[7] ?? '';

        // Column mapping based on Bangla Headings:
        // 0: Name BN
        // 1: Name EN
        // 2: Category Name
        // 3: Department Name
        // 4: Unit Name
        // 5: Amount
        // 6: Service Type
        // 7: Description

        // Category Auto-Creation
        $categoryId = null;
        if ($categoryName) {
            $category = ItemCategory::firstOrCreate(
                ['name_en' => $categoryName],
                ['name_bn' => $categoryName, 'status' => 'active']
            );
            $categoryId = $category->id;
        }

        // Unit Auto-Creation
        $unitId = null;
        if ($unitName) {
            $unit = ItemUnit::firstOrCreate(
                ['name_en' => $unitName],
                ['name_bn' => $unitName, 'status' => 'active']
            );
            $unitId = $unit->id;
        }

        // Department Auto-Creation
        $departmentId = Auth::user()->inv_permission; // Default to user's department
        if ($departmentName) {
            $department = ItemDepartment::firstOrCreate(
                ['name' => $departmentName]
            );
            $departmentId = $department->id;
        }

  
        $item=[
            'name_bn' => $nameBn ?? $nameEn,
            'name_en' => $nameEn,
            'cat_id' => $categoryId,
            'unit_id' => $unitId,
            'dept_id' => $departmentId,
            'service_type' => $serviceType,
            'duration' => 0, // Not in new format
            'max_times' => 0, // Not in new format
            'amount' => $amount,
            'description' => $description,
        ];

        if(!empty($nameBn)){
            return new Item($item);
        }else{
           return null;
        }
    }
}
