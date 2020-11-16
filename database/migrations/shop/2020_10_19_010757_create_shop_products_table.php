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
			// JSON
			$table->text('colors')->nullable();
			// JSON
			$table->longText('description')->nullable();
			$table->foreignId('img_id')->constrained('shop_images');
			$table->unsignedDecimal('price', 8, 2);
			$table->unsignedTinyInteger('rating', false)->default(0);
			// Dimension and weight
			$table->unsignedInteger('weight')->default(0);
			$table->string('size')->default("0;0;0");
			// CONFIG
			$table->string('tags')->nullable();
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
