<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopAnnouncementProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_announcement_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained('shop_products');
			$table->foreignId('announcement_id')->constrained('shop_announcements');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shop_announcement_products');
	}
}
