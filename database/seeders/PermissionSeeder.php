<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view obat']);
        Permission::create(['name' => 'create obat']);
        Permission::create(['name' => 'edit obat']);
        Permission::create(['name' => 'delete obat']);
        Permission::create(['name' => 'view kategori obat']);
        Permission::create(['name' => 'create kategori obat']);
        Permission::create(['name' => 'edit kategori obat']);
        Permission::create(['name' => 'delete kategori obat']);
        Permission::create(['name' => 'view supplier']);
        Permission::create(['name' => 'create supplier']);
        Permission::create(['name' => 'edit supplier']);
        Permission::create(['name' => 'delete supplier']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view obat');
        $adminRole->givePermissionTo('create obat');
        $adminRole->givePermissionTo('edit obat');
        $adminRole->givePermissionTo('view kategori obat');
        $adminRole->givePermissionTo('create kategori obat');
        $adminRole->givePermissionTo('edit kategori obat');
        $adminRole->givePermissionTo('view supplier');
        $adminRole->givePermissionTo('create supplier');
        $adminRole->givePermissionTo('edit supplier');

        $superadminRole = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule

        // create users
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => 1,
            'password' => bcrypt('password')
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role_id' => 2,
            'password' => bcrypt('password')
        ]);
        $user->assignRole($superadminRole);
    }
}
