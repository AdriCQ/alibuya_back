<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductOptionColorImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_product_option_color_images', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained('shop_products');
			$table->foreignId('image_id')->constrained('shop_images');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_product_option_color_images');
	}
}
