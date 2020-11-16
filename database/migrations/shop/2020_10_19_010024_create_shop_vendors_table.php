<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopVendorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_vendors', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
			$table->string('title');
			// JSON
			$table->longText('description')->nullable();
			// JSON
			$table->string('type')->nullable();
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
		Schema::dropIfExists('shop_vendors');
	}
}
