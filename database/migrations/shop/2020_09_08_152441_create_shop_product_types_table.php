<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_product_types', function (Blueprint $table) {
			$table->id();
			$table->foreignId('category_id')->constrained('shop_categories');
			$table->string('tag');
			$table->json('title');
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
		Schema::dropIfExists('shop_product_types');
	}
}
