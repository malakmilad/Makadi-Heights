<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = Role::updateOrCreate(['name' => 'sales']);
        $manager = Role::updateOrCreate(['name' => 'manager']);
        $finance = Role::updateOrCreate(['name' => 'finance']);
        $super_admin = Role::updateOrCreate(['name' => 'super admin']);
        $makadi_admin = Role::updateOrCreate(['name' => 'makadi-admin']);
        $makadi_super_admin = Role::updateOrCreate(['name' => 'makadi-super-admin']);

        // ------------------------------------------------------------------------------

        $edit_rates_permission = Permission::updateOrCreate([
            'name' => 'rates.edit',
        ]);

        // ------------------------------------------------------------------------------

        $edit_permission = Permission::updateOrCreate([
            'name' => 'payments.edit',
        ]);

        $create_permission = Permission::updateOrCreate([
            'name' => 'payments.create',
        ]);

        $delete_permission = Permission::updateOrCreate([
            'name' => 'payments.delete',
        ]);

        $show_permissions = Permission::updateOrCreate([
            'name' => 'payments.show',
        ]);

        $export_permissions = Permission::updateOrCreate([
            'name' => 'payments.export',
        ]);

        // ------------------------------------------------------------------------------

        $edit_faqs_permission = Permission::updateOrCreate([
            'name' => 'faqs.edit',
        ]);

        $create_faqs_permission = Permission::updateOrCreate([
            'name' => 'faqs.create',
        ]);

        $delete_faqs_permission = Permission::updateOrCreate([
            'name' => 'faqs.delete',
        ]);

        $show_faqs_permissions = Permission::updateOrCreate([
            'name' => 'faqs.show',
        ]);

        // ------------------------------------------------------------------------------

        $create_user_permission = Permission::updateOrCreate([
            'name' => 'users.create',
        ]);

        // ------------------------------------------------------------------------------

        $roles_permission = Permission::updateOrCreate([
            'name' => 'roles',
        ]);

        $sales->syncPermissions([
            $show_permissions,
            $show_faqs_permissions,
            $create_permission,
            $edit_permission,
            $export_permissions,
        ]);

        $manager->syncPermissions([
            $edit_permission,
            $create_permission,
            $show_permissions,
            $edit_faqs_permission,
            $create_faqs_permission,
            $delete_faqs_permission,
            $show_faqs_permissions,
            $create_user_permission,
            $export_permissions,
        ]);

        $finance->syncPermissions([$export_permissions, $show_permissions, $edit_rates_permission]);

        $super_admin->syncPermissions([
            $edit_permission,
            $create_permission,
            $show_permissions,
            $delete_permission,
            $edit_faqs_permission,
            $create_faqs_permission,
            $delete_faqs_permission,
            $show_faqs_permissions,
            $create_user_permission,
            $export_permissions,
            $edit_rates_permission,
            $roles_permission,
        ]);

        $makadi_super_admin->syncPermissions([
            $edit_permission,
            $create_permission,
            $show_permissions,
            $delete_permission,
            $edit_faqs_permission,
            $create_faqs_permission,
            $delete_faqs_permission,
            $show_faqs_permissions,
            $create_user_permission,
            $export_permissions,
            $edit_rates_permission,
        ]);

        $makadi_admin->syncPermissions([
            $edit_permission,
            $create_permission,
            $show_permissions,
            $delete_permission,
            $edit_faqs_permission,
            $create_faqs_permission,
            $delete_faqs_permission,
            $show_faqs_permissions,
            $create_user_permission,
            $export_permissions,
        ]);
        $user_4 = User::updateOrCreate(
            ['email' => 'super-admin@makadi-heights.com'],
            ['name' => 'super admin','password' => Hash::make("MakadiAdmin#1")]
        )->syncRoles(['makadi-admin']);
        // )->assignRole('manager');
        $user_3 = User::firstWhere(
            'email',
            'super-admin@makadi-heights.com'
        )->syncRoles(['super admin','makadi-admin']);


        // $user_5 = User::updateOrCreate(
        //     ['email' => 'sales@makadiheights.com'],
        //     ['name' => 'Makadi Heights Sales','password' => Hash::make("Makadi#1")]
        // )->syncRoles(['sales']);

        // $user_6= User::updateOrCreate(
        //     ['email' => 'finance@makadiheights.com'],
        //     ['name' => 'Makadi Heights Finance','password' => Hash::make("FinanceMakadi#1")]
        // )->syncRoles(['finance']);

        // $user_7= User::updateOrCreate(
        //     ['email' => 'manager@makadiheights.com'],
        //     ['name' => 'Makadi Heights Manager','password' => Hash::make("ManagerMakadi#1")]
        // )->syncRoles(['manager']);
    }
}
