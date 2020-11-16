<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPacksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_packs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users');
			$table->string('delivery_method');
			// JSON
			$table->longText('persons_info');
			$table->boolean('buy')->default(false);
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
		Schema::dropIfExists('shop_packs');
	}
}
