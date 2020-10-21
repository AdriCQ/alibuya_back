<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create([
			'first_name' => 'Adrian',
			'last_name' => 'Capote',
			'email' => 'adrian.capote95@zoho.com',
			'password' => Hash::make('password'),
			'gender' => 'm',
			'country' => 'cu',
			'lang' => 'es',
			'address' => 'Calle Silencio #32, Palmira, Cienfuegos'
		]);

		User::query()->first()->assignRole('Developer');

		$users = User::factory()->count(10)->create();
		foreach ($users as $user) {
			$user->assignRole('Guest');
		}
	}
}
