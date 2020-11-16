<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Product::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'img_id' => Image::factory(),
			'title' => $this->faker->words(3, true),
			'brand' => $this->faker->word,
			'colors' => $this->faker->randomElement([json_encode([$this->faker->colorName, $this->faker->colorName]), null]),
			'tax' => $this->faker->randomFloat(2, 0, 200),
			'description' => json_encode([
				$this->faker->words(8, true),
				$this->faker->words(8, true),
				$this->faker->words(8, true),
				$this->faker->words(8, true),
			]),
			'price' => $this->faker->randomFloat(2, 0, 5000),
			'rating' => $this->faker->numberBetween(0, 5),
			'weight' => $this->faker->numberBetween(0, 1000),
			'size' => $this->faker->numberBetween(1, 100) . ';' . $this->faker->numberBetween(1, 100) . ';' . $this->faker->numberBetween(1, 100),
			'tags' => json_encode($this->faker->randomElements(Category::$CATEGORIES)),
		];
	}
}
