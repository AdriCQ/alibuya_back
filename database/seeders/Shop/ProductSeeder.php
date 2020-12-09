<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder
 */
class ProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->seedProducts(10, 10);
	}

	/**
	 * seedProducts
	 *
	 * @param  mixed $limit
	 * @param  mixed $repeat
	 * @return void
	 */
	private function seedProducts(int $limit = 10, $repeat = 1)
	{
		$faker = Factory::create();

		for ($r = 0; $r < $repeat; $r++) {
			$products = [];
			for ($i = 0; $i < $limit; $i++) {
				$type = ProductType::query()->find($faker->numberBetween(1, ProductType::query()->count()));
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
					'type_id' => $type->id,
					'category_id' => $type->category->id,
					'available_cant' => $faker->numberBetween(1, 1000)
				]);
			}
			Product::query()->insert($products);
		}
	}
}
