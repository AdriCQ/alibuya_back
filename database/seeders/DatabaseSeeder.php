<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\Shop\ShopSeeder;
use Database\Seeders\User\PermissionSeeder;
use Database\Seeders\User\UserSeeder;

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
			CountrySeeder::class,
			PermissionSeeder::class,
			UserSeeder::class,
			ShopSeeder::class
		]);
	}
}
