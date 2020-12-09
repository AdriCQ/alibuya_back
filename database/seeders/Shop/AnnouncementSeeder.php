<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Announcement;
use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * AnnouncementSeeder
 */
class AnnouncementSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->seedAnnouncements(10);
		$this->seedProducts(8);
	}

	/**
	 * seedAnnouncements
	 *
	 * @param  mixed $limit
	 * @param  mixed $repeat
	 * @return void
	 */
	private function seedAnnouncements(int $limit = 10, int $repeat = 1)
	{
		$faker = Factory::create();
		for ($r = 0; $r < $repeat; $r++) {
			$announcements = [];
			for ($i = 0; $i < $limit; $i++) {
				array_push($announcements, [
					'title' => json_encode([
						'es' => $faker->words(3, true),
						'en' => $faker->words(3, true),
					]),
					'text' => [
						'es' => $faker->text,
						'en' => $faker->text,
					],
					'active' => $faker->boolean(60),
					'tags' => json_encode($faker->words(5)),
					'type' => $faker->randomElement(Announcement::$TYPES),
					'prints' => $faker->numberBetween(1, 1000),
					'priority' => $faker->numberBetween(1, 100),
					'image_id' => $faker->numberBetween(1, Image::query()->count())
				]);
			}
		}
		Announcement::query()->insert($announcements);
	}

	/**
	 * seedProducts
	 *
	 * @param  mixed $limit
	 * @return void
	 */
	private function seedProducts($limit = 10)
	{
		$faker = Factory::create();
		$announcementProducts = [];
		for ($i = 1; $i < Announcement::query()->count(); $i++) {
			for ($r = 0; $r < $limit; $r++) {
				array_push($announcementProducts, [
					'product_id' => $faker->numberBetween(1, Product::query()->count()),
					'announcement_id' => $i
				]);
			}
		}
		DB::table('shop_announcement_products')->insert($announcementProducts);
	}
}
