<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('mobile_phone')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('gender', 1)->nullable();
			$table->string('country', 3)->default('CU');
			$table->string('lang', 3)->default('es');
			$table->string('address')->nullable();
			$table->rememberToken();
			$table->timestamps();

			$table->foreign('country')->references('code')->on('countries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
