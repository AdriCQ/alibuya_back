<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\Vendor;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Seed Images
		Image::factory()->count(5)->create();
		// Seed Vendors
		Vendor::factory()->count(4)->hasShopProducts(10)->create();
	}
}
