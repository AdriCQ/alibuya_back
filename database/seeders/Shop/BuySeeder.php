<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Buy;
use App\Models\Shop\Pack;
use App\Models\Shop\Pivot\PackProduct;
use App\Models\Shop\Product;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * BuySeeder
 */
class BuySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->seedPacks();
		$this->seedPackProducts(10, 3);
		$this->seedBuy(3);
		$this->seedBuyPacks(10, 2);
	}

	/**
	 * seedPacks
	 *
	 * @param  mixed $_limit
	 * @param  mixed $_repeat
	 * @return void
	 */
	private function seedPacks(int $_limit = 10, int $_repeat = 1)
	{
		$faker = Factory::create();
		$packArray = [];
		for ($r = 0; $r < $_repeat; $r++) {
			for ($i = 0; $i < $_limit; $i++) {
				array_push($packArray, [
					'user_id' => $faker->numberBetween(1, User::query()->count()),
					'delivery_method' => $faker->words(3, true),
					'destinataries' => json_encode([]),
					'status' => $faker->randomElement(Pack::$STATUS),
				]);
			}
		}
		Pack::query()->insert($packArray);
	}

	/**
	 * seedPackProducts
	 *
	 * @param  mixed $_limit
	 * @param  mixed $_repeat
	 * @return void
	 */
	private function seedPackProducts(int $_limit = 10, int $_repeat = 1)
	{
		$faker = Factory::create();
		$packProductsArray = [];
		for ($r = 0; $r < $_repeat; $r++) {
			for ($i = 0; $i < $_limit; $i++) {
				array_push($packProductsArray, [
					'pack_id' => $faker->numberBetween(1, Pack::query()->count()),
					'product_id' => $faker->numberBetween(1, Product::query()->count()),
					'options_details' => json_encode([
						'color' => $faker->colorName
					]),
					'cart_cant' => $faker->numberBetween(1, 10),
					'status' => $faker->randomElement(PackProduct::$STATUS)
				]);
			}
		}
		PackProduct::query()->insert($packProductsArray);
	}

	/**
	 * seedBuy
	 *
	 * @param  mixed $_limit
	 * @param  mixed $_repeat
	 * @return void
	 */
	private function seedBuy(int $_limit = 10, int $_repeat = 1)
	{
		$faker = Factory::create();
		$buyArray = [];
		for ($r = 0; $r < $_repeat; $r++) {
			for ($i = 0; $i < $_limit; $i++) {
				array_push($buyArray, [
					'user_id' => $faker->numberBetween(1, User::query()->count()),
					'price' => $faker->numberBetween(1, 1000),
					'status' => $faker->randomElement(Buy::$STATUS),
				]);
			}
		}
		Buy::query()->insert($buyArray);
	}

	/**
	 * seedBuyPacks
	 *
	 * @param  mixed $_limit
	 * @param  mixed $_repeat
	 * @return void
	 */
	private function seedBuyPacks(int $_limit = 10, int $_repeat = 1)
	{
		$faker = Factory::create();
		$buyPacksArray = [];
		for ($r = 0; $r < $_repeat; $r++) {
			for ($i = 0; $i < $_limit; $i++) {
				array_push($buyPacksArray, [
					'buy_id' => $faker->numberBetween(1, Buy::query()->count()),
					'pack_id' => $faker->numberBetween(1, Pack::query()->count()),
					'cant' => $faker->numberBetween(1, 10),
				]);
			}
		}
		DB::table('shop_buy_packs')->insert($buyPacksArray);
	}
}
