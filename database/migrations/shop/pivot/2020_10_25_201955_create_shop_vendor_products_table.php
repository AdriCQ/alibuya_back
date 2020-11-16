<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopVendorProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_vendor_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vendor_id')->constrained('shop_vendors');
			$table->foreignId('product_id')->constrained('shop_products');

			$table->boolean('suggested')->default(false);
			$table->unsignedSmallInteger('cant')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_vendor_products');
	}
}
