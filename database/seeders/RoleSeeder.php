<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(["name"=> "school admin", 'guard_name'=>'api' ]);
        $role2 = Role::create(["name"=> "system admin", 'guard_name'=>'api']);
        $role3 = Role::create(["name"=> "teacher", 'guard_name'=>'api']);
    }
}
