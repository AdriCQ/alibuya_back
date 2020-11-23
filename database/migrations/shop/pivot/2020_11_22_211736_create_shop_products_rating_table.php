<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsRatingTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_products_rating', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained('shop_products');
			$table->foreignId('user_id')->constrained('users');
			$table->unsignedTinyInteger('rating')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_products_rating');
	}
}
