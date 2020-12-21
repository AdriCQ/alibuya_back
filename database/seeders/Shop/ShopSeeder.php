<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Image;
use App\Models\Shop\Vendor;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * ShopSeeder
 */
class ShopSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Image::query()->insert([
			'title' => 'Alibuya',
			'tags' => \json_encode(['alibuya']),
			'paths' => \json_encode([
				'xs' => '/images/alibuya-xs.png',
				'sm' => '/images/alibuya-sm.png',
				'md' => '/images/alibuya-md.png',
				'lg' => '/images/alibuya-lg.png',
				'xl' => '/images/alibuya-xl.png',
			])
		]);
		$this->call([
			CategoriesSeeder::class,
		]);


		$this->seedVendors();
		$this->call([
			ProductSeeder::class,
			// AnnouncementSeeder::class
		]);
	}

	/**
	 * seedVendors
	 *
	 * @return void
	 */
	private function seedVendors()
	{
		$faker = Factory::create();

		Vendor::query()->insert(
			[
				'user_id' => 1,
				'title' => $faker->words(4, true),
				'img_id' => 1,
				'description' => '',
				'active' => true,
				'tags' => \json_encode([''])
			]
		);
	}
}
