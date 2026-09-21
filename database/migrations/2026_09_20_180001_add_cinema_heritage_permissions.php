<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check/Add parent permission for Page Management
        $parentKey = 'page_management';
        $parent = DB::table('permissions')->where('key', $parentKey)->first();
        if (!$parent) {
            DB::table('permissions')->insertGetId([
                'name' => 'পেইজ ম্যানেজমেন্ট',
                'key' => $parentKey,
                'cat_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Check/Add child permission for Cinema Heritage
        $permissionKey = 'cinema_heritage';
        $permission = DB::table('permissions')->where('key', $permissionKey)->first();
        if (!$permission) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => 'চলচ্চিত্রের ইতিহাস ও ঐতিহ্য',
                'key' => $permissionKey,
                'cat_id' => $parentKey,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $permissionId = $permission->id;
        }

        // Determine roles table name
        $rolesTable = Schema::hasTable('roles') ? 'roles' : (Schema::hasTable('role_and_permissions') ? 'role_and_permissions' : null);

        if ($rolesTable) {
            $roles = DB::table($rolesTable)->pluck('id');
            foreach ($roles as $roleId) {
                $exists = DB::table('roll_has')
                    ->where('roll_id', $roleId)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$exists) {
                    DB::table('roll_has')->insert([
                        'roll_id' => $roleId,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permission = DB::table('permissions')->where('key', 'cinema_heritage')->first();
        if ($permission) {
            DB::table('roll_has')->where('permission_id', $permission->id)->delete();
            DB::table('permissions')->where('id', $permission->id)->delete();
        }
    }
};
