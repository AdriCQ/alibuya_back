<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTypeFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = ProductType::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $catMax = Category::query()->count();
    return [
      'category_id'
      => $this->faker->numberBetween(1, $catMax),
      'name' => $this->faker->words(3, true),
    ];
  }
}
