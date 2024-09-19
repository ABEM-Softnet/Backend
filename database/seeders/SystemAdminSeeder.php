<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creates a system admin user
        $user = \App\Models\User::factory()->create([
            'name' => 'system admin',
            'email' => 'system@admin.com',
            // 'phone_no' => '+251'
            'password' => bcrypt('softnet1234'),
        ]);

        //Fetches the role to be attached for api
        $systemAdminRoleApi = Role::where('name', 'system admin')->where('guard_name', 'api')->first();

        //Fetches the role to be attached for web
        $systemAdminRoleWeb = Role::where('name', 'system admin')->where( 'guard_name', 'web')->first();

        $user->assignRole($systemAdminRoleApi);
        $user->assignRole($systemAdminRoleWeb);
    }
}
