<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBuyPacksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_buy_packs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('buy_id')->constrained('shop_buy');
			$table->foreignId('pack_id')->constrained('shop_packs');
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
		Schema::dropIfExists('shop_buy_packs');
	}
}
