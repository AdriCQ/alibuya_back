<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPackProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_pack_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('pack_id')->constrained('shop_packs');
			$table->foreignId('product_id')->constrained('shop_products');
			// JSON
			$table->json('options_details')->nullable();
			$table->unsignedSmallInteger('cart_cant')->default(1);
			$table->string('status', 16)->default('created');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_pack_products');
	}
}
