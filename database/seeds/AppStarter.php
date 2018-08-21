<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Permission;
use App\Menu;

class AppStarter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset spatie cache
        app()['cache']->forget('spatie.permission.cache');
        // start seed
        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'Administrator',
            'email' => 'as.ramdan13@gmail.com'
        ]);
        $role = Role::create([
            'name' => 'administrator'
        ]);
        $user->syncRoles([ $role ]);

        $menu = Menu::create([
            'name' => 'Home',
            'slug' => '/',
            'icon' => 'fa fa-home',
            'order_no' => 1
        ]);
        $menu->assignRole($role);
        $perm = Permission::create([ 'name' => 'change password' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);

        $menu = Menu::create([
            'name' => 'Setting',
            'slug' => 'settings',
            'icon' => 'fa fa-cogs',
            'order_no' => 99
        ]);
        $menu->assignRole($role);
        $setting_id = $menu->id;

        $menu = Menu::create([
            'parent_id' => $setting_id,
            'name' => 'Menu',
            'slug' => 'menus',
            'icon' => 'fa fa-indent',
            'order_no' => 1
        ]);
        $menu->assignRole($role);
        $perm = Permission::create([ 'name' => 'index menu' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'create menu' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'update menu' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'delete menu' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);

        $menu = Menu::create([
            'parent_id' => $setting_id,
            'name' => 'Role',
            'slug' => 'roles',
            'icon' => 'fa fa-group',
            'order_no' => 2
        ]);
        $menu->assignRole($role);
        $perm = Permission::create([ 'name' => 'index role' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'create role' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'update role' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'delete role' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);

        $menu = Menu::create([
            'parent_id' => $setting_id,
            'name' => 'User',
            'slug' => 'users',
            'icon' => 'fa fa-user',
            'order_no' => 3
        ]);
        $menu->assignRole($role);
        $perm = Permission::create([ 'name' => 'index user' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'create user' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'update user' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
        $perm = Permission::create([ 'name' => 'delete user' ]);
        $menu->givePermissionTo($perm);
        $role->givePermissionTo($perm);
    }
}
