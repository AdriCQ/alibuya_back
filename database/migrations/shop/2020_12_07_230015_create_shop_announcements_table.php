<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopAnnouncementsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_announcements', function (Blueprint $table) {
			$table->id();
			$table->string("type", 50);
			$table->json("title");
			$table->json("text")->nullable();
			$table->json("tags");
			$table->json("options")->nullable();
			$table->boolean('active')->default(false);
			$table->unsignedTinyInteger('priority')->default(0);
			$table->unsignedInteger('prints')->default(0);
			$table->foreignId('image_id')->constrained('shop_images');
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
		Schema::dropIfExists('shop_announcements');
	}
}
