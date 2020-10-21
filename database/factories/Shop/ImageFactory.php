<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Image::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->words(3, true),
      'type' => $this->faker->word,
      'path' => $this->faker->text(50)
    ];
  }
}
