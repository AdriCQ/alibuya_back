<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_products', function (Blueprint $table) {
			$table->id();
			// Basic
			$table->string('title', 50);
			$table->string('brand')->nullable();
			$table->unsignedDecimal('tax')->default(0);
			$table->longText('description')->nullable();
			$table->unsignedDecimal('price', 8, 2);
			// Dimension and weight
			$table->unsignedInteger('weight')->default(0);
			// CONFIG
			$table->boolean('active')->default(false);
			$table->longText('tags');
			$table->longText('options');
			$table->unsignedTinyInteger('rating', false)->default(0);
			$table->boolean('suggested')->default(false);
			$table->foreignId('vendor_id')->constrained('shop_vendors');
			$table->foreignId('type_id')->constrained('shop_product_types');
			$table->unsignedInteger('cant')->default(1);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_products');
	}
}
