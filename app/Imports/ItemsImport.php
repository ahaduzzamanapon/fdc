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
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // ✅ Trim সব
        $row = array_map(fn($v) => is_string($v) ? trim($v) : $v, $row);

        $nameBn         = $row[0] ?? null;
        $nameEn         = $row[1] ?? null;
        $categoryName   = $row[2] ?? null;
        $departmentName = $row[3] ?? null;
        $unitName       = $row[4] ?? null;
        $amount         = is_numeric($row[5] ?? null) ? $row[5] : 0;
        $serviceType    = $row[6] ?? 'goods';
        $description    = $row[7] ?? '';

        // ❌ empty skip
        if (empty($nameBn)) {
            return null;
        }

        // ✅ Normalize service type
        $serviceType = mb_strtolower($serviceType);
        $serviceType = preg_replace('/\s+/', ' ', $serviceType);

        $map = [
            'দিন'        => 'day',
            'প্রতিদিন'    => 'day',
            'প্রতি দিন'   => 'day',
            'শিফিট'      => 'shift',
            'প্রতি শিফিট' => 'shift',
        ];

        $serviceType = $map[$serviceType] ?? $serviceType;

        // ✅ FINAL duplicate check (BN + service_type)
        $nameBnCheck = strtolower(trim($nameBn));

        $exists = Item::whereRaw('LOWER(name_bn) = ?', [$nameBnCheck])
            ->where('service_type', $serviceType)
            ->exists();

        if ($exists) {
            return null;
        }

        // 🔥 Category
        $categoryId = null;
        if (!empty($categoryName)) {
            $category = ItemCategory::firstOrCreate(
                ['name_en' => $categoryName],
                ['name_bn' => $categoryName, 'status' => 'active']
            );
            $categoryId = $category->id;
        }

        // 🔥 Unit
        $unitId = null;
        if (!empty($unitName)) {
            $unit = ItemUnit::firstOrCreate(
                ['name_en' => $unitName],
                ['name_bn' => $unitName, 'status' => 'active']
            );
            $unitId = $unit->id;
        }

        // 🔥 Department
        $departmentId = Auth::user()->inv_permission;

        if (!empty($departmentName)) {
            $department = ItemDepartment::firstOrCreate([
                'name' => $departmentName
            ]);
            $departmentId = $department->id;
        }

        // ✅ Insert
        return new Item([
            'name_bn'      => $nameBn,
            'name_en'      => $nameEn,
            'cat_id'       => $categoryId,
            'unit_id'      => $unitId,
            'dept_id'      => $departmentId,
            'service_type' => $serviceType,
            'duration'     => 0,
            'max_times'    => 0,
            'amount'       => $amount,
            'description'  => $description,
        ]);
    }
}
