<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use App\Models\Shop\Promotion;
use App\Models\Shop\Vendor;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
		$this->seedProducts(10, 10);
		$this->seedPromotions(10);
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

	/**
	 * seedPromotions
	 *
	 * @param  mixed $limit
	 * @param  mixed $repeat
	 * @return void
	 */
	private function seedPromotions(int $limit = 10, int $repeat = 1)
	{
		$faker = Factory::create();
		$typeTags = [];
		$productTypes = ProductType::all();
		// Seed Promotions
		foreach ($productTypes as $type) {
			$tag = $type->tag;
			array_push($typeTags, $tag);
		}
		for ($r = 0; $r < $repeat; $r++) {
			$promotions = [];
			for ($i = 0; $i < $limit; $i++) {
				array_push($promotions, [
					'title' => \json_encode([
						'es' => $faker->words(5, true),
						'en' => $faker->words(5, true)
					]),
					'tags' => \json_encode($faker->randomElements($typeTags, 2)),
					'priority' => $faker->numberBetween(1, 100),
					'active' => $faker->boolean(80)
				]);
			}
			Promotion::query()->insert($promotions);
		}

		// Seed Promotion products
		foreach (Promotion::all() as $promotion) {
			$promotionProducts = [];
			for ($r = 0; $r < 8; $r++) {
				array_push(
					$promotionProducts,
					[
						'promotion_id' => $promotion->id,
						'product_id' => $faker->numberBetween(1, Product::query()->count())
					]
				);
			}
			DB::table('shop_promotion_products')->insert($promotionProducts);
		}
	}
}
