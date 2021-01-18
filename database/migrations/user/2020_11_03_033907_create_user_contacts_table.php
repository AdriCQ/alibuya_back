<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_contacts', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users');
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('ci', 11);
			$table->string('address');
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
		Schema::dropIfExists('user_contacts');
	}
}
