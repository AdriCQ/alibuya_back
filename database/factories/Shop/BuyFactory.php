<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Buy;
use App\Models\Shop\Pack;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuyFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Buy::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$maxUser = User::query()->count();
		return [
			'user_id' => $this->faker->numberBetween(1, $maxUser),
			'price' => $this->faker->randomFloat(2, 0, 5000),
		];
	}
}
