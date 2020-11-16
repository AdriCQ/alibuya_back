<?php

namespace Database\Factories\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = User::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'first_name' => $this->faker->firstName(),
			'last_name' => $this->faker->lastName,
			'email' => $this->faker->unique()->safeEmail,
			'mobile_phone' => $this->faker->phoneNumber,
			'email_verified_at' => now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'gender' => $this->faker->randomElement(['m', 'f', 'n']),
			'country' => strtoupper($this->faker->countryCode),
			'lang' => $this->faker->languageCode,
			'address' => $this->faker->address,
			'remember_token' => Str::random(10),
		];
	}
}
