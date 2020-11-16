<?php

namespace Database\Seeders;

use Database\Seeders\User\PermissionSeeder;
use Database\Seeders\User\UserSeeder;
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
			CountrySeeder::class,
			PermissionSeeder::class,
			UserSeeder::class,
			ShopSeeder::class
		]);
	}
}
