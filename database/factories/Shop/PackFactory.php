<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Pack;
use App\Models\Shop\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Pack::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$persons = [];
		for ($i = 0; $i < 5; $i++) {
			array_push($persons, [
				'first_name' => $this->faker->firstName,
				'last_name' => $this->faker->lastName,
				'address' => $this->faker->address
			]);
		}
		return [
			'user_id' => $this->faker->numberBetween(1, User::query()->count()),
			'delivery_method' => $this->faker->word,
			'persons_info' => json_encode($persons),
		];
	}

	/**
	 * Buy State
	 */
	public function buyDone()
	{
		return $this->state([
			'buy' => true,
		]);
	}
}
