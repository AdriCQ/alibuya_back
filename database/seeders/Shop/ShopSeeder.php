<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
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
		$this->seedVendors();
		$this->seedProducts(10);
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

	private function seedProducts(int $limit = 10, $repeat = 1)
	{
		$faker = Factory::create();

		for ($r = 0; $r < $repeat; $r++) {
			$products = [];
			for ($i = 0; $i < $limit; $i++) {
				array_push($products, [
					'title' => $faker->words(8, true),
					'brand' => $faker->word,
					'img_id' => 1,
					'tax' => $faker->numberBetween(0, 100),
					'description' => "<h1>" . $faker->words(3, true) . "</h1><p>" . $faker->text . "</p><p>" . $faker->text . "</p>",
					'price' => $faker->numberBetween(10, 10000),
					'weight' => $faker->numberBetween(0, 1000),
					'active' => $faker->boolean(80),
					'tags' => json_encode($faker->words(5)),
					'options' => \json_encode([
						'colors' => [
							$faker->colorName => $faker->hexColor,
							$faker->colorName => $faker->hexColor,
							$faker->colorName => $faker->hexColor,
						]
					]),
					'rating' => $faker->numberBetween(0, 5),
					'suggested' => $faker->boolean(),
					'vendor_id' => 1,
					'type_id' => $faker->numberBetween(1, ProductType::query()->count()),
					'available_cant' => $faker->numberBetween(1, 1000)
				]);
			}
			Product::query()->insert($products);
		}
	}
}
