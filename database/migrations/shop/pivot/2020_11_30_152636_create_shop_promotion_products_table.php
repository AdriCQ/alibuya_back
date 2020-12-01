<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPromotionProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_promotion_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained('shop_products');
			$table->foreignId('promotion_id')->constrained('shop_promotions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_promotion_products');
	}
}
