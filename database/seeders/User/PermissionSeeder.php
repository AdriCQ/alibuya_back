<?php

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		/**
		 * -----------------------------------------
		 *	Roles
		 * -----------------------------------------
		 */

		// Developer
		$develper = Role::create(['name' => 'Developer']);
		// Guest
		$guest = Role::create(['name' => 'Guest']);
		// Vendor
		$vendor = Role::create(['name' => 'Vendor']);

		/**
		 * -----------------------------------------
		 *	Permissions
		 * -----------------------------------------
		 */

		$BASE_PERMISSIONS = ['list', 'get'];
		$ADVANCE_PERMISSIONS = ['create', 'update', 'destroy'];
		// Product Permissions
		$PERMISSION_NAME = 'products';
		foreach ($BASE_PERMISSIONS as $permission) {
			Permission::create(['name' => $PERMISSION_NAME . '.' . $permission]);
			// Grant Permission
			$guest->givePermissionTo($PERMISSION_NAME . '.' . $permission);
			$vendor->givePermissionTo($PERMISSION_NAME . '.' . $permission);
		}
		foreach ($ADVANCE_PERMISSIONS as $permission) {
			Permission::create(['name' => $PERMISSION_NAME . '.' . $permission]);
			// Grant Permission
			$vendor->givePermissionTo($PERMISSION_NAME . '.' . $permission);
		}

		// Vendor Permission
		$PERMISSION_NAME = 'vendors';
		foreach ($BASE_PERMISSIONS as $permission) {
			Permission::create(['name' => $PERMISSION_NAME . '.' . $permission]);
			// Grant Permission
			$vendor->givePermissionTo($PERMISSION_NAME . '.' . $permission);
		}
		foreach ($ADVANCE_PERMISSIONS as $permission) {
			Permission::create(['name' => $PERMISSION_NAME . '.' . $permission]);
			// Grant Permission
			$vendor->givePermissionTo($PERMISSION_NAME . '.' . $permission);
		}
	}
}
