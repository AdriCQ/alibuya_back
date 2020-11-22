<?php

namespace Database\Seeders;

use App\Models\Shop\Buy;
use App\Models\Shop\Category;
use App\Models\Shop\Image;
use App\Models\Shop\Pack;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use App\Models\Shop\Vendor;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Factory::create();
		// Seed Images
		// Image::factory()->count(10)->create();

		// Seed categories
		$categories = [];
		foreach (Category::$CATEGORIES as $category) {
			array_push($categories, [
				'title' => json_encode([
					'en' => 'en_' . $category,
					'es' => 'es_' . $category,
				]),
				'tag' => $category
			]);
		}
		Category::query()->insert($categories);

		// Buy 
		// Buy::factory()->has(
		// 	Pack::factory()->has(
		// 		Product::factory()->count(1)->has(
		// 			Vendor::factory()
		// 		)
		// 	)->buyDone()->count(1)
		// )->count(1)->create();
		ProductType::factory()->count(20)->create();
		// Vendor::factory()->has(Product::factory()->count(5))->count(20)->create();

		// $cat_prod = [];
		// foreach (Product::all() as $product) {
		// 	array_push($cat_prod, [
		// 		'product_id' => $product->id,
		// 		'category_id' => $faker->numberBetween(1, Category::query()->count())
		// 	]);
		// }
		// DB::table('shop_category_products')->insert($cat_prod);
	}
}
