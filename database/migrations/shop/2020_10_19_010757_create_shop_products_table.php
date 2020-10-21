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
			$table->foreignId('vendor_id')->constrained('shop_vendors')->cascadeOnDelete();
			// Basic
			$table->string('title', 50);
			// JSON
			$table->string('description')->nullable();
			$table->foreignId('img_id')->constrained('shop_images')->cascadeOnDelete();
			$table->unsignedDecimal('price', 8, 2);
			$table->unsignedTinyInteger('rating', false)->default(0);
			// Dimension and weight
			$table->unsignedInteger('weight')->default(0);
			$table->string('size')->default("0;0;0");
			// CONFIG
			$table->boolean('suggested')->default(false);
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
