<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Vendor;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Vendor::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $userMax = User::query()->count();
    return [
      'user_id'
      => $this->faker->numberBetween(1, $userMax),
      'title' => $this->faker->words(3, true),
      'description' => json_encode($this->faker->words(8)),
      'type' => $this->faker->word,
      'active' => $this->faker->boolean()
    ];
  }
}
