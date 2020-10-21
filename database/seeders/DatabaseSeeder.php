<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionSeeder;
use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Shop\ShopSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			PermissionSeeder::class,
			UserSeeder::class,
			ShopSeeder::class
		]);
	}
}
